from rest_framework import serializers
from .models import Producto, Direccion, Pedido, DetallePedido


class ProductoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Producto
        fields = ['id', 'nombre', 'descripcion', 'precio', 'stock', 'activo']
        extra_kwargs = {
            'id': {'read_only': True}
        }
class DireccionSerializer(serializers.ModelSerializer):
    class Meta:
        model = Direccion
        fields = ['id', 'calle', 'ciudad', 'codigo_postal']

class ProductoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Producto
        fields = ['id', 'nombre', 'descripcion', 'precio', 'stock', 'activo']

class DetallePedidoSerializer(serializers.ModelSerializer):
    class Meta:
        model = DetallePedido
        fields = ['id', 'producto', 'cantidad', 'precio_unitario']

class PedidoSerializer(serializers.ModelSerializer):
    direccion_detalle = DireccionSerializer(source='direccion_envio', read_only=True)
    detalles = DetallePedidoSerializer(source='detallepedido_set', many=True, read_only=True)

    class Meta:
        model = Pedido
        fields = [
            'id',
            'cliente',
            'direccion_envio',
            'direccion_detalle',
            'fecha',
            'detalles'
        ]

