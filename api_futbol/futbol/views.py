from rest_framework.viewsets import ModelViewSet
from .models import Equipo, Jugador
from .serializers import EquipoSerializer, JugadorSerializer

class EquipoViewSet(ModelViewSet):
    queryset = Equipo.objects.all()
    serializer_class = EquipoSerializer

class JugadorViewSet(ModelViewSet):
    queryset = Jugador.objects.all()
    serializer_class = JugadorSerializer




