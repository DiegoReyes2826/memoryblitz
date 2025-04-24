const colores = ['rojo', 'verde', 'azul', 'amarillo'];
let secuencia = [];
let secuenciaJugador = [];
let nivel = 0;
let dificultad = 'facil';
let incremento = 1;
let inicioSecuencia = 2;
let nivelMaximo = localStorage.getItem("nivelMaximo") || 0;


// Sonidos por color
const sonidos = {
  rojo: new Audio("./assets/sounds/rojo.mp3.wav"),
  verde: new Audio("assets/sounds/verde.mp3.wav"),
  azul: new Audio("assets/sounds/azul.mp3.wav"),
  amarillo: new Audio("assets/sounds/amarillo.mp3.wav"),
  correcto: new Audio("assets/sounds/correcto.mp3.wav"),
  error: new Audio("assets/sounds/error.mp3.wav")
};


const estadoJuego = document.getElementById('estado-juego');

const mejorNivelPrincipal = document.getElementById("mejor-nivel-principal");
function mostrarMejorNivelPrincipal() {
  mejorNivelPrincipal.textContent = `🏆 Mejor nivel alcanzado: ${nivelMaximo}`;
}


const mejorNivel = document.getElementById("mejor-nivel");



function actualizarMejorNivel() {
  mejorNivel.textContent = `🎯 Mejor nivel: ${nivelMaximo}`;
}


const pantallaConfiguracion = document.getElementById("pantalla-configuracion");
document.getElementById("config-btn").addEventListener("click", () => {
  pantallaPrincipal.style.display = "none";
  pantallaConfiguracion.style.display = "block";
});




const pantallaPrincipal = document.getElementById('pantalla-principal');
const pantallaDificultad = document.getElementById('pantalla-dificultad');
const pantallaJuego = document.getElementById('pantalla-juego');

const botones = colores.reduce((acc, color) => {
  acc[color] = document.getElementById(color);
  return acc;
}, {});

// Ir desde pantalla principal a seleccionar dificultad
document.getElementById('btn-ir-dificultad').addEventListener('click', () => {
  pantallaPrincipal.style.display = 'none';
  pantallaDificultad.style.display = 'block';
});

// Volver desde dificultad al inicio
function volverAInicio() {
  pantallaDificultad.style.display = 'none';
  pantallaPrincipal.style.display = 'block';
}


// Seleccionar dificultad y empezar juego
function seleccionarDificultad(nivelElegido) {
  dificultad = nivelElegido;

  switch (dificultad) {
    case 'facil':
      inicioSecuencia = 2;
      incremento = 1;
      break;
    case 'medio':
      inicioSecuencia = 3;
      incremento = 2;
      break;
    case 'dificil':
      inicioSecuencia = 4;
      incremento = 3;
      break;
  }

  pantallaDificultad.style.display = 'none';
  pantallaJuego.style.display = 'block';
  iniciarJuego();
}

function iniciarJuego() {
  nivel = 0;
  secuencia = [];
  secuenciaJugador = [];
  estadoJuego.textContent = `Nivel 1: Observa la secuencia`;
  siguienteNivel();
}

function siguienteNivel() {
  secuenciaJugador = [];
  let cantidadNuevos = nivel === 0 ? inicioSecuencia : incremento;

  for (let i = 0; i < cantidadNuevos; i++) {
    const colorAleatorio = colores[Math.floor(Math.random() * colores.length)];
    secuencia.push(colorAleatorio);
  }

  nivel++;
  estadoJuego.textContent = `Nivel ${nivel}: Observa la secuencia`;
  reproducirSecuencia();
}

function reproducirSecuencia() {
  let i = 0;
  const intervalo = setInterval(() => {
    const color = secuencia[i];
    activarBoton(color);
    i++;
    if (i >= secuencia.length) {
      clearInterval(intervalo);
      estadoJuego.textContent = `Tu turno: Repite la secuencia`;
    }
  }, 800);
}

function activarBoton(color) {
  const boton = botones[color];
  boton.classList.add('activo');
  sonidos[color].currentTime = 0; // Reinicia el sonido si se repite
  sonidos[color].play();          // 🔊 Reproduce el sonido del color

  setTimeout(() => {
    boton.classList.remove('activo');
  }, 400);
}


colores.forEach(color => {
  botones[color].addEventListener('click', () => {
    if (secuencia.length === 0) return;

    secuenciaJugador.push(color);
    activarBoton(color);

    const i = secuenciaJugador.length - 1;
    if (secuenciaJugador[i] !== secuencia[i]) {
      estadoJuego.textContent = '¡Fallaste! Reiniciando...';
      setTimeout(reiniciarJuego, 2000);
      if (secuenciaJugador[i] !== secuencia[i]) {
        sonidos.error.play(); // 🔊 Sonido de error
        estadoJuego.textContent = '¡Fallaste! Reiniciando...';
        setTimeout(reiniciarJuego, 2000);
        return;
      }
      
    }

    if (secuenciaJugador.length === secuencia.length) {
      sonidos.correcto.play(); // 🔊 Sonido de éxito
      estadoJuego.textContent = '¡Correcto! Siguiente nivel...';
       // Guardar si superó el récord
       if (nivel > nivelMaximo) {
        nivelMaximo = nivel;
        localStorage.setItem("nivelMaximo", nivelMaximo);
        actualizarMejorNivel();
        mostrarMejorNivelPrincipal();
      
        // Enviar nivel al backend
        const datos = new URLSearchParams();
        datos.append('modo', dificultad);
        datos.append('nivel', nivel);
      
        fetch('guardarNivel.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: datos.toString()
        })
        .then(response => response.json())
        .then(data => {
          console.log('✅ Nivel guardado:', data.message);
        })
        .catch(error => {
          console.error('❌ Error al guardar el nivel:', error);
        });
      }
      
      setTimeout(siguienteNivel, 1000);
    }
    
  });
});

function reiniciarJuego() {
  pantallaJuego.style.display = 'none';
  pantallaPrincipal.style.display = 'block';
  estadoJuego.textContent = 'Selecciona una dificultad para comenzar';
}



let sonidoActivo = true;

document.getElementById("toggle-sonido").addEventListener("click", function () {
  sonidoActivo = !sonidoActivo;

  // Actualizar botón
  this.textContent = sonidoActivo ? "🔇 Desactivar sonido" : "🔊 Activar sonido";

  // Muteo todos los sonidos
  Object.values(sonidos).forEach(audio => {
    audio.muted = !sonidoActivo;
  });
});




document.getElementById("reiniciar-record").addEventListener("click", () => {
  localStorage.removeItem("nivelMaximo");
  nivelMaximo = 0;
  actualizarMejorNivel();
  mostrarMejorNivelPrincipal();
  alert("¡Puntaje reiniciado!");
});


function ocultarTodasLasPantallas() {
  pantallaPrincipal.style.display = "none";
  pantallaDificultad.style.display = "none";
  pantallaJuego.style.display = "none";
  pantallaConfiguracion.style.display = "none";
  pantallaAyuda.style.display = "none";
  pantallaNombre.style.display = "none";

}

document.getElementById("config-btn").addEventListener("click", () => {
  ocultarTodasLasPantallas();
  pantallaConfiguracion.style.display = "block";
});

document.getElementById("btn-ir-dificultad").addEventListener("click", () => {
  ocultarTodasLasPantallas();
  pantallaDificultad.style.display = "block";
});

function volverAInicio() {
  ocultarTodasLasPantallas();
  pantallaPrincipal.style.display = "block";
}


const pantallaAyuda = document.getElementById("pantalla-ayuda");

document.getElementById("ayuda-btn").addEventListener("click", () => {
  ocultarTodasLasPantallas();
  pantallaAyuda.style.display = "block";
});

const pantallaNombre = document.getElementById("pantalla-nombre");
const inputNombre = document.getElementById("input-nombre");

let nombreJugador = localStorage.getItem("nombreJugador") || "";


function guardarNombre() {
  const nombre = inputNombre.value.trim();
  if (nombre.length === 0) {
    alert("Por favor ingresa un nombre.");
    return;
  }

  nombreJugador = nombre;
  localStorage.setItem("nombreJugador", nombreJugador);

  mostrarSaludo();
  ocultarTodasLasPantallas();
  pantallaPrincipal.style.display = "block";
}


const saludoNombre = document.getElementById("saludo-nombre");

function mostrarSaludo() {
  saludoNombre.textContent = nombreJugador
    ? `👋 ¡Bienvenido, ${nombreJugador}!`
    : "";
}


if (!nombreJugador) {
  ocultarTodasLasPantallas();
  pantallaNombre.style.display = "block";
} else {
  mostrarSaludo();
}


actualizarMejorNivel();
mostrarMejorNivelPrincipal();


