$(document).ready(function() {

    $('#table-usuario').on('click', 'button.btn-edit', function(e) {

        e.preventDefault()

        // Limpar os campos da minha janela modal
        $('.modal-title').empty()
        $('.modal-body').empty()

        // Criar um novo título para nossa janela modals
        $('.modal-title').append('Edição do usuário')

        let IDUSUARIO = `IDUSUARIO=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: IDUSUARIO,
            url: "src/usuario/model/view-usuario.php",
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/usuario/view/form-usuario.html', function() {
                        $('#NOME').val(dado.dados.NOME)
                        $('#EMAIL').val(dado.dados.EMAIL)
                        $('#SENHA').val(dado.dados.SENHA)
                        $('#IDUSUARIO').val(dado.dados.IDUSUARIO)
                        var tipo = dado.dados.TIPO_USUARIO_IDTIPO_USUARIO
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            assync: false,
                            url: 'src/tipo-usuario/model/all-tipo.php',
                            success: function(dados) {
                                for (const dado of dados) {
                                    if (dado.IDTIPO_USUARIO == tipo) {
                                        $('#TIPO_USUARIO_IDTIPO_USUARIO').append(`<option selected value="${dado.IDTIPO_USUARIO}">${dado.DESCRICAO}</option>`)
                                    } else {
                                        $('#TIPO_USUARIO_IDTIPO_USUARIO').append(`<option value="${dado.IDTIPO_USUARIO}">${dado.DESCRICAO}</option>`)
                                    }
                                }
                            }
                        })

                        var curso = dado.dados.CURSO_IDCURSO
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            assync: false,
                            url: 'src/curso/model/all-curso.php',
                            success: function(dados) {
                                for (const dado of dados) {
                                    if (dado.IDCURSO == curso) {
                                        $('#CURSO_IDCURSO').append(`<option selected value="${dado.IDCURSO}">${dado.NOME}</option>`)
                                    } else {
                                        $('#CURSO_IDCURSO').append(`<option value="${dado.IDCURSO}">${dado.NOME}</option>`)
                                    }
                                }
                            }
                        })
                    })
                    $('.btn-save').show()
                    $('.btn-save').removeAttr('data-operation')
                    $('#modal-usuario').modal('show')
                }
            }
        })
    })

})