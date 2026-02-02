from django.contrib import admin
from .models import Cliente, Direccion, Producto, Pedido, DetallePedido

admin.site.register(Cliente)
admin.site.register(Direccion)
admin.site.register(Producto)
admin.site.register(Pedido)
admin.site.register(DetallePedido)


# Register your models here.
