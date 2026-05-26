from django.db import models

class Posicion(models.Model):
    nombre = models.CharField(max_length=50)
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        ordering = ['nombre']
        verbose_name = 'Posición'

    def __str__(self):
        return self.nombre


class Equipo(models.Model):
    nombre = models.CharField(max_length=100)
    ciudad = models.CharField(max_length=100)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        ordering = ['nombre']
        verbose_name = 'Equipo'

    def __str__(self):
        return self.nombre


class Jugador(models.Model):
    nombre = models.CharField(max_length=100)
    dorsal = models.IntegerField()
    posicion = models.ForeignKey(Posicion, on_delete=models.SET_NULL, null=True)
    equipo = models.ForeignKey(Equipo, on_delete=models.CASCADE, related_name="jugadores")

    class Meta:
        ordering = ['equipo', 'dorsal']
        verbose_name = 'Jugador'

    def __str__(self):
        return f"{self.nombre} ({self.dorsal})"


class Partido(models.Model):
    fecha = models.DateField()
    equipo_local = models.ForeignKey(Equipo, on_delete=models.CASCADE, related_name="local")
    equipo_visitante = models.ForeignKey(Equipo, on_delete=models.CASCADE, related_name="visitante")

    jugadores = models.ManyToManyField(Jugador, through="Alineacion", blank=True)

    class Meta:
        ordering = ['fecha']
        verbose_name = 'Partido'

    def __str__(self):
        return f"{self.equipo_local} vs {self.equipo_visitante}"


class Alineacion(models.Model):
    jugador = models.ForeignKey(Jugador, on_delete=models.CASCADE)
    partido = models.ForeignKey(Partido, on_delete=models.CASCADE)
    minutos = models.IntegerField(default=0)
    goles = models.IntegerField(default=0)

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['jugador', 'partido'], name='unique_jugador_partido')
        ]
        verbose_name = 'Alineación'

    def __str__(self):
        return f"{self.jugador} en {self.partido}"

class Entrenador(models.Model):
    nombre = models.CharField(max_length=100)

class PerfilEntrenador(models.Model):
    entrenador = models.OneToOneField(Entrenador, on_delete=models.CASCADE)
    nacionalidad = models.CharField(max_length=100)




