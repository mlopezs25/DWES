from django.contrib import admin
from .models import Cliente, Categoria, Producto, Pedido, LineaPedido

admin.site.register(Cliente)
admin.site.register(Categoria)
admin.site.register(Producto)
admin.site.register(Pedido)
admin.site.register(LineaPedido)
