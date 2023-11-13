#!/bin/bash

# Inicializar el puntaje
puntaje=100

# Verificar si se proporciona un parámetro
if [ $# -eq 0 ]; then
    echo "Por favor, proporciona un parámetro de entrada."
    exit 1
fi

# Obtener la entrada del usuario
entrada=$1

# Analizar la longitud de la entrada
longitud=${#entrada}

# Verificar las condiciones y ajustar el puntaje
if [ $longitud -lt 8 ]; then
    puntaje=$((puntaje - 50))
elif [ $longitud -lt 12 ]; then
    puntaje=$((puntaje - 20))
elif [ $longitud -lt 32 ]; then
    puntaje=$((puntaje - 10))
fi

# Mostrar el puntaje final
echo "Score: $puntaje"
