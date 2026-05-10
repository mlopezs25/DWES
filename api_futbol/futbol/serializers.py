from rest_framework import serializers
from .models import Equipo, Jugador

class EquipoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Equipo
        fields = ['id', 'nombre', 'ciudad']
        extra_kwargs = {
            'id': {'read_only': True}
        }


class JugadorSerializer(serializers.ModelSerializer):
    class Meta:
        model = Jugador
        fields = ['id', 'nombre', 'dorsal', 'posicion', 'equipo']
        extra_kwargs = {
            'id': {'read_only': True}
        }
