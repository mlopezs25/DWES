from rest_framework import serializers
from .models import Equipo, Jugador, Alineacion, Partido, PerfilEntrenador, Entrenador, Posicion


class EquipoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Equipo
        fields = ['id', 'nombre', 'ciudad']


class JugadorSerializer(serializers.ModelSerializer):
    equipo_detalle = EquipoSerializer(source='equipo', read_only=True)
    equipo = serializers.PrimaryKeyRelatedField(queryset=Equipo.objects.all())

    class Meta:
        model = Jugador
        fields = ['id', 'nombre', 'dorsal', 'posicion', 'equipo', 'equipo_detalle']


class AlineacionSerializer(serializers.ModelSerializer):
    class Meta:
        model = Alineacion
        fields = ['id', 'partido', 'jugador', 'minutos', 'goles']


class PartidoSerializer(serializers.ModelSerializer):
    """Para crear partidos (sin jugadores)."""
    class Meta:
        model = Partido
        fields = '__all__'


class PartidoDetalleSerializer(serializers.ModelSerializer):
    """Para mostrar un partido con sus alineaciones."""
    alineaciones = AlineacionSerializer(source='alineacion_set', many=True, read_only=True)

    class Meta:
        model = Partido
        fields = ['id', 'fecha', 'equipo_local', 'equipo_visitante', 'alineaciones']


class PerfilEntrenadorSerializer(serializers.ModelSerializer):
    class Meta:
        model = PerfilEntrenador
        fields = ['nacionalidad']


class EntrenadorSerializer(serializers.ModelSerializer):
    perfil = PerfilEntrenadorSerializer(read_only=True)

    class Meta:
        model = Entrenador
        fields = ['id', 'nombre', 'perfil']


class PosicionSerializer(serializers.ModelSerializer):
    class Meta:
        model = Posicion
        fields = '__all__'


class AgregarJugadorSerializer(serializers.Serializer):
    jugador_id = serializers.IntegerField()
    minutos = serializers.IntegerField(required=False, default=90)
    goles = serializers.IntegerField(required=False, default=0)





