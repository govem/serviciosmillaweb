$('#actividad').change(function() {
  var actividad = $('#actividad').val()
  if (actividad == 6) {
    $('#divotro').show()
  } else {
    $('#divotro').hide()
  }
})

$('input,select')
  .not('[type=submit]')
  .jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      console.log(errors)
    },
    submitSuccess: function($form, event) {
      event.preventDefault()
      var name = $('#horaForm #nombreCompleto').val()
      var rut = $('#horaForm #rut').val()
      var direccion = $('#horaForm #direccion').val()
      var correo = $('#horaForm #correo').val()
      var marca = $('#horaForm #marca').val()
      var celular = $('#horaForm #celular').val()
      var actividad = $('#horaForm #actividad').val()
      var otro = $('#horaForm #otro').val()

      if (actividad == 1) {
        actividad = 'Mantención de horas y reseteo de equipo'
      } else if (actividad == 2) {
        actividad = 'No cae pellet (sin fin trabado)'
      } else if (actividad == 3) {
        actividad = 'Encendido (bujía de encendido)'
      } else if (actividad == 4) {
        actividad = 'Instalación horizontal y puesta en marcha'
      } else if (actividad == 5) {
        actividad = 'Instalación vertical'
      } else if (actividad == 6) {
        actividad = 'Otro (especifique)'
      }

      $.ajax({
        url: 'http://34.220.31.60/serviciosmilla/mail/pedir_hora.php',
        type: 'POST',
        dataType: 'text',
        crossDomain: true,
        data: {
          name: name,
          rut: rut,
          direccion: direccion,
          celular: celular,
          marca: marca,
          correo: correo,
          actividad: actividad,
          otro: otro
        },
        cache: false,
        success: function() {
          alert('Su hora ha sido enviada, nos pondremos en contacto con usted a la brevedad posible')
          window.location.href = 'index.html'
        },
        error: function(xhr, status, error) {
          var err = eval('(' + xhr.responseText + ')')
          alert('Surgió un error enviando su solicitud, favor reintente')
        }
      })
    },
    filter: function() {
      return $(this).is(':visible')
    }
  })
