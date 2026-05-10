import django_filters
from .models import Partido

class PartidoFilter(django_filters.FilterSet):

    fecha_min = django_filters.DateFilter(
        field_name="fecha",
        lookup_expr="gte"
    )

    fecha_max = django_filters.DateFilter(
        field_name="fecha",
        lookup_expr="lte"
    )

    class Meta:
        model = Partido
        fields = ['equipo_local', 'equipo_visitante']
