$(document).ready(function() {

    $('#table-curso').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Limpar os campos da minha janela modal
        $('.modal-title').empty()
        $('.modal-body').empty()

        // Criar um novo título para nossa janela modals
        $('.modal-title').append('Visualização do curso')

        let IDCURSO = `IDCURSO=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: IDCURSO,
            url: "src/curso/model/view-curso.php",
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/curso/view/form-curso.html', function() {
                        $('#NOME').val(dado.dados.NOME)
                        $('#NOME').attr('readonly', 'true')
                        var eixo = dado.dados.EIXO_IDEIXO
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            assync: false,
                            url: 'src/eixo/model/all-eixo.php',
                            success: function(dados) {
                                for (const dado of dados) {
                                    if (dado.IDEIXO == eixo) {
                                        $('#EIXO_IDEIXO').append(`<option value="${dado.IDEIXO}">${dado.NOME}</option>`)
                                    }
                                }
                            }
                        })
                        $('#EIXO_IDEIXO').attr('readonly', 'true')
                    })
                    $('.btn-save').hide()
                    $('#modal-curso').modal('show')
                }
            }
        })
    })

})