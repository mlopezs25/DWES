from django.urls import path
from .views import ProductoListAPIView, ProductoDetailAPIView

urlpatterns = [
    path('productos/', ProductoListAPIView.as_view()),
    path('productos/<int:pk>/', ProductoDetailAPIView.as_view()),
]
