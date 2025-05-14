<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Alerta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Obtener todos los productos con sus relaciones
     */
    public function index()
    {
        try {
            $productos = Producto::with(['alerta', 'usuario'])->get();

            return response()->json([
                'success' => true,
                'data' => $productos
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener productos: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener los productos');
        }
    }

    /**
     * Crear nuevo producto con manejo de relaciones
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nombreProducto' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0|max:1000',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $producto = Producto::create([
            'nombreProducto' => $request->nombreProducto,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'idUsuario' => Auth::id() // Usar el ID del usuario autenticado
        ]);

        return response()->json([
            'success' => true,
            'data' => $producto,
            'message' => 'Producto creado exitosamente'
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al crear el producto',
            'error' => $e->getMessage()
        ], 500);
    }
}
    /**
     * Mostrar un producto específico con relaciones
     */
    public function show($id)
    {
        try {
            $producto = Producto::with(['alerta', 'usuario'])->find($id);

            if (!$producto) {
                return $this->notFoundResponse('Producto no encontrado');
            }

            return $this->successResponse($producto);
        } catch (\Exception $e) {
            Log::error('Error al obtener producto: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener el producto');
        }
    }

    /**
     * Actualizar producto con manejo de stock y alertas
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombreProducto' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $producto = Producto::find($id);

            if (!$producto) {
                return $this->notFoundResponse('Producto no encontrado');
            }

            // Actualizar datos básicos
            $producto->update($request->only(['nombreProducto', 'descripcion', 'precio', 'stock']));

            // Manejo de alertas según stock
            $this->handleStockAlerts($producto);

            return $this->successResponse(
                $producto->fresh(['alerta', 'usuario']),
                'Producto actualizado exitosamente'
            );

        } catch (\Exception $e) {
            Log::error('Error al actualizar producto: ' . $e->getMessage());
            return $this->errorResponse('Error al actualizar el producto', $e->getMessage());
        }
    }

    /**
     * Eliminar producto y su alerta asociada
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::with('alerta')->find($id);

            if (!$producto) {
                return $this->notFoundResponse('Producto no encontrado');
            }

            // Eliminar alerta asociada si existe
            if ($producto->alerta) {
                $producto->alerta()->delete();
            }

            $producto->delete();

            return $this->successResponse(null, 'Producto eliminado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            return $this->errorResponse('Error al eliminar el producto');
        }
    }

    /**
     * Obtener productos con stock bajo
     */
    public function productosStockBajo()
    {
        try {
            $productos = Producto::with(['alerta', 'usuario'])
                            ->where('stock', '<', 10)
                            ->get();

            return $this->successResponse([
                'data' => $productos,
                'count' => $productos->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener productos con stock bajo: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener productos con stock bajo');
        }
    }

    /**
     * Métodos auxiliares para respuestas consistentes
     */
    protected function successResponse($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    protected function errorResponse($message, $error = null, $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => config('app.debug') ? $error : null
        ], $code);
    }

    protected function notFoundResponse($message)
    {
        return $this->errorResponse($message, null, 404);
    }

    protected function validationErrorResponse($errors)
    {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $errors
        ], 422);
    }

    /**
     * Reducir el stock de un producto
     */
    public function reduceStock(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $producto = Producto::find($id);

            if (!$producto) {
                return $this->notFoundResponse('Producto no encontrado');
            }

            if ($producto->stock < $request->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuficiente',
                    'stock_disponible' => $producto->stock
                ], 400);
            }

            // Reducir el stock
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Manejar alertas de stock bajo
            $this->handleStockAlerts($producto);

            return $this->successResponse(
                $producto->fresh(['alerta', 'usuario']),
                'Stock actualizado exitosamente'
            );

        } catch (\Exception $e) {
            Log::error('Error al reducir stock: ' . $e->getMessage());
            return $this->errorResponse('Error al reducir el stock', $e->getMessage());
        }
    }

    /**
     * Manejo de alertas según stock
     */
    protected function handleStockAlerts(Producto $producto)
    {
        if ($producto->stock < 10) {
            if (!$producto->alerta) {
                $alerta = Alerta::create([
                    'tipoMensaje' => 'Stock bajo',
                    'estadoProducto' => 'Stock crítico: ' . $producto->stock . ' unidades'
                ]);
                $producto->update(['idAlerta' => $alerta->id]);
            } else {
                $producto->alerta()->update([
                    'estadoProducto' => 'Stock crítico: ' . $producto->stock . ' unidades'
                ]);
            }
        } elseif ($producto->alerta) {
            $producto->alerta()->delete();
            $producto->update(['idAlerta' => null]);
        }
    }
    public function getMultiple(Request $request)
    {
        $ids = explode(',', $request->query('ids'));

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No se proporcionaron IDs de productos'
            ], 400);
        }

        try {
            $productos = Producto::whereIn('id', $ids)->get();

            return response()->json([
                'success' => true,
                'productos' => $productos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los productos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
