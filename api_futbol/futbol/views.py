from rest_framework.viewsets import ModelViewSet
from django_filters.rest_framework import DjangoFilterBackend
from rest_framework.filters import SearchFilter, OrderingFilter
from rest_framework.decorators import action
from rest_framework.response import Response
from rest_framework import status
from .filters import PartidoFilter
from .models import Equipo, Jugador, Partido, Alineacion, Posicion
from .serializers import (
    EquipoSerializer,
    JugadorSerializer,
    PartidoSerializer,
    AlineacionSerializer,
    PosicionSerializer,
    AgregarJugadorSerializer,
    PartidoDetalleSerializer,
)


class EquipoViewSet(ModelViewSet):
    queryset = Equipo.objects.all()
    serializer_class = EquipoSerializer

    filter_backends = [DjangoFilterBackend, SearchFilter, OrderingFilter]
    filterset_fields = ['ciudad']
    search_fields = ['nombre', 'ciudad']
    ordering_fields = ['nombre', 'ciudad']
    ordering = ['nombre']


class JugadorViewSet(ModelViewSet):
    queryset = Jugador.objects.all()
    serializer_class = JugadorSerializer

    filter_backends = [DjangoFilterBackend, SearchFilter, OrderingFilter]
    filterset_fields = ['equipo', 'posicion']
    search_fields = ['nombre']
    ordering_fields = ['dorsal', 'nombre']
    ordering = ['dorsal']


class PartidoViewSet(ModelViewSet):
    queryset = Partido.objects.all()

    def get_serializer_class(self):
        if self.action in ['retrieve', 'list']:
            from .serializers import PartidoDetalleSerializer
            return PartidoDetalleSerializer
        return PartidoSerializer

    filter_backends = [DjangoFilterBackend, SearchFilter, OrderingFilter]
    filterset_class = PartidoFilter
    search_fields = ['equipo_local__nombre', 'equipo_visitante__nombre']
    ordering_fields = ['fecha']
    ordering = ['fecha']

    @action(detail=True, methods=['post'])
    def agregar_jugador(self, request, pk=None):
        partido = self.get_object()

        serializer = AgregarJugadorSerializer(data=request.data)
        serializer.is_valid(raise_exception=True)

        jugador_id = serializer.validated_data['jugador_id']
        minutos = serializer.validated_data['minutos']
        goles = serializer.validated_data.get('goles', 0)

        try:
            jugador = Jugador.objects.get(id=jugador_id)
        except Jugador.DoesNotExist:
            return Response({"error": "Jugador no existe"}, status=400)

        alineacion, creada = Alineacion.objects.get_or_create(
            partido=partido,
            jugador=jugador,
            defaults={'minutos': minutos, 'goles': goles}
        )

        if not creada:
            return Response({"error": "El jugador ya está en la alineación"}, status=409)

        return Response(
            {"mensaje": "Jugador añadido correctamente"},
            status=status.HTTP_201_CREATED
        )


class AlineacionViewSet(ModelViewSet):
    queryset = Alineacion.objects.all()
    serializer_class = AlineacionSerializer

    filter_backends = [DjangoFilterBackend, SearchFilter, OrderingFilter]
    filterset_fields = ['jugador', 'partido']
    search_fields = ['jugador__nombre']
    ordering_fields = ['minutos', 'goles']
    ordering = ['-minutos']



class PosicionViewSet(ModelViewSet):
    queryset = Posicion.objects.all()
    serializer_class = PosicionSerializer

    filter_backends= [DjangoFilterBackend, SearchFilter, OrderingFilter]
    search_fields = ['nombre']
    ordering_fields = ['nombre']
    ordering = ['nombre']


