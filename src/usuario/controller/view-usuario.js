$(document).ready(function() {

    $('#table-usuario').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Limpar os campos da minha janela modal
        $('.modal-title').empty()
        $('.modal-body').empty()

        // Criar um novo título para nossa janela modals
        $('.modal-title').append('Visualização do usuário')

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
                        $('#NOME').attr('readonly', 'true')
                        $('#EMAIL').val(dado.dados.EMAIL)
                        $('#EMAIL').attr('readonly', 'true')
                        $('#SENHA').val(dado.dados.SENHA)
                        $('#SENHA').attr('readonly', 'true')
                        var tipo = dado.dados.TIPO_USUARIO_IDTIPO_USUARIO
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            assync: false,
                            url: 'src/tipo-usuario/model/all-tipo.php',
                            success: function(dados) {
                                for (const dado of dados) {
                                    if (dado.IDTIPO_USUARIO == tipo) {
                                        $('#TIPO_USUARIO_IDTIPO_USUARIO').append(`<option value="${dado.IDTIPO_USUARIO}">${dado.DESCRICAO}</option>`)
                                    }
                                }
                            }
                        })
                        $('#TIPO_USUARIO_IDTIPO_USUARIO').attr('readonly', 'true')

                        var curso = dado.dados.CURSO_IDCURSO
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            assync: false,
                            url: 'src/curso/model/all-curso.php',
                            success: function(dados) {
                                for (const dado of dados) {
                                    if (dado.IDCURSO == curso) {
                                        $('#CURSO_IDCURSO').append(`<option value="${dado.IDCURSO}">${dado.NOME}</option>`)
                                    }
                                }
                            }
                        })
                        $('#CURSO_IDCURSO').attr('readonly', 'true')
                    })
                    $('.btn-save').hide()
                    $('#modal-usuario').modal('show')
                }
            }
        })
    })

})