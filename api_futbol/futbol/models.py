from django.db import models

class Posicion(models.Model):
    nombre = models.CharField(max_length=50)

    def __str__(self):
        return self.nombre


class Equipo(models.Model):
    nombre = models.CharField(max_length=100)
    ciudad = models.CharField(max_length=100)

    def __str__(self):
        return self.nombre


class Jugador(models.Model):
    nombre = models.CharField(max_length=100)
    dorsal = models.IntegerField()
    posicion = models.ForeignKey(Posicion, on_delete=models.SET_NULL, null=True)
    equipo = models.ForeignKey(Equipo, on_delete=models.CASCADE, related_name="jugadores")

    def __str__(self):
        return f"{self.nombre} ({self.dorsal})"


class Partido(models.Model):
    fecha = models.DateField()
    equipo_local = models.ForeignKey(Equipo, on_delete=models.CASCADE, related_name="local")
    equipo_visitante = models.ForeignKey(Equipo, on_delete=models.CASCADE, related_name="visitante")

    def __str__(self):
        return f"{self.equipo_local} vs {self.equipo_visitante}"


class Alineacion(models.Model):
    jugador = models.ForeignKey(Jugador, on_delete=models.CASCADE)
    partido = models.ForeignKey(Partido, on_delete=models.CASCADE)
    minutos_jugados = models.IntegerField(default=0)
    goles = models.IntegerField(default=0)

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['jugador', 'partido'], name='unique_jugador_partido')
        ]

    def __str__(self):
        return f"{self.jugador} en {self.partido}"

