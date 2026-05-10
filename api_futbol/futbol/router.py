from rest_framework.routers import DefaultRouter
from .views import (
    EquipoViewSet,
    JugadorViewSet,
    PartidoViewSet,
    AlineacionViewSet,
    PosicionViewSet
)

router = DefaultRouter()
router.register(r'equipos', EquipoViewSet)
router.register(r'jugadores', JugadorViewSet)
router.register(r'posiciones', PosicionViewSet)
router.register(r'partidos', PartidoViewSet)
router.register(r'alineaciones', AlineacionViewSet)





