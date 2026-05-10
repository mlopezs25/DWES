from rest_framework.routers import DefaultRouter
from .views import EquipoViewSet, JugadorViewSet

router = DefaultRouter()
router.register(r'equipos', EquipoViewSet, basename='equipos')
router.register(r'jugadores', JugadorViewSet, basename='jugadores')


