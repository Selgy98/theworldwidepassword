#!/bin/bash

# Inicializar el puntaje
puntaje=10

# Verificar si se proporciona un parámetro
if [ $# -eq 0 ]; then
    echo "Por favor, proporciona un parámetro de entrada."
    exit 1
fi

# Obtener la entrada del usuario
entrada=$1

# Analizar la longitud de la entrada
longitud=${#entrada}

# Contar la cantidad de caracteres especiales
num_caracteres_especiales=$(echo "$entrada" | tr -cd '[:punct:]' | wc -c)

# Verificar las condiciones y ajustar el puntaje
if [ $num_caracteres_especiales -eq 0 ]; then
    puntaje=$((puntaje - 30))
elif [ $num_caracteres_especiales -eq 1 ]; then
    puntaje=$((puntaje - 15))
fi

# Verificar las condiciones adicionales y ajustar el puntaje
if [ $longitud -lt 8 ]; then
    puntaje=$((puntaje - 50))
elif [ $longitud -lt 12 ]; then
    puntaje=$((puntaje - 20))
elif [ $longitud -lt 32 ]; then
    puntaje=$((puntaje - 10))
fi

# Asegurarse de que el puntaje no sea negativo
if [ $puntaje -lt 0 ]; then
    puntaje=0
fi

# Mostrar el puntaje final
echo "SCORE: $puntaje"

