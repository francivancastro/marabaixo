$(document).ready(function() {
    $("#pesquisa_btn_limpar").click(function() {
        var form = $("#pesquisa_form");
        if (form.length) {
            form.find(".pesquisa_field").val("");
            form.submit();
        }        
    });
    var form = $("#pesquisa_form");
    if (form.length) {
        form.hide();
        form.find(".pesquisa_field").each(function(idc, obj) {
            if ($(this).val().length) {
                form.show();
                return;
            }
        });
    }
    $('[data-toggle="tooltip"]').tooltip();
    $(".mask_cpf").inputmask("999.999.999-99");
    $(".mask_cnpj").inputmask("99.999.999/9999-99");
    
    $(".marca-todos").change(function() {
        var class_name = $(this).attr("id");
        if (class_name && class_name.length) {
            $("." + class_name).prop("checked", $(this).prop("checked"));
        }
    });
    
    $(".link_confirma").click(function(event) {
        event.preventDefault();
        var obj = $(this);
        $.modalConfirmacao({ 
            "conteudo" : "Confirmar Operação?",
            "titulo": "Atenção",
            "id": "myModal" + obj.prop("id"),
            "confirma": function(value) {
                if (value) {
                    window.location = obj.attr("href");
                }
            }
        });
    });
    
    $.datepicker.setDefaults( { "dayNames" : [ "Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado" ],
                                "dayNamesMin" : [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb" ],
                                "dayNamesShort" : [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb" ], 
                                "monthNames" : [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
                                "monthNamesShort" : [ "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez" ] } );
    $.datepicker.formatDate( "dd/mm/yy");
    
    $(".mask_cep").inputmask("99.999-999");
    
    $(".mask_data").inputmask("99/99/9999");
    $(".mask_data").datepicker({ dateFormat: "dd/mm/yy" });
    
    $.clearErrorMessage = function() {
        $.clearMessage("warning");
    }
    
    $.clearSuccessMessage = function() {
        $.clearMessage("info");
    }
    
    $.clearAllMessage = function() {
        $.clearErrorMessage();
        $.clearSuccessMessage();
    }
    
    $.clearMessage = function(type) {
        var ctrl = $(".alert-" + type);
        if (ctrl && ctrl.length) {
            ctrl.remove();
        }
    }
    
    jQuery.addErrorMessage = function(message) {
        $.addMessage({ "message": message, "type": "warning" });
    }
    
    jQuery.addSuccessMessage = function(message) {
        $.addMessage({ "message": message, "type": "info" });
    }
    
    jQuery.addMessage = function(opp) {
        var padrao = { "message" : "", "type" : "warning" };
        var options = $.extend( {}, padrao, opp);
        var ctrl = $(".alert-" + options.type + " ul");
        if (ctrl && !ctrl.length) {
            alert = $('<div>', { "class" : "alert alert-" + options.type, "role" : "alert" });
            ctrl = $('<ul>');
            ctrl.appendTo(alert);
            alert.appendTo($("#idMessage"));
        }
        var li = $("<li>" + options.message + "</li>").appendTo(ctrl);
        
        $('#centro-conteudo').animate({ scrollTop: 0}, 0);
    }
    
    //janela de confirmação
    jQuery.modalConfirmacao = function(options){
        if (typeof options.titulo == "undefined") {
            options.titulo = "Título Padrão";
        }
        if (typeof options.conteudo == "undefined") {
            options.conteudo = "Mensagem Padrão";
        }
        if (typeof options.id == "undefined") {
            options.id = "myModalConfirm";
        }
        var html = '<div class="modal fade" id="' + options.id + '">';
        html += '<div class="modal-dialog">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
        html += '<h4 class="modal-title">' + options.titulo + '</h4>';
        html += '</div>';
        html += '<div class="modal-body">' + options.conteudo + '</div>';
        html += '<div class="modal-footer">';
        html += '<button id="btnCancela" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>';
        html += '<button id="btnConfirma" class="btn btn-primary">Confirmar</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        jQuery(html).appendTo("body");
        $("#" + options.id).on("confirma", function(event, data) {
            if (typeof options.confirma != "undefined") {
                options.confirma(data);
            }
            $(this).modal("hide");
        });
        $("#btnConfirma").bind("click", function() {
            $("#" + options.id).trigger("confirma", true );
        });
        $("#btnCancela").click(function() {
            $("#" + options.id).trigger("confirma", false );
        });
        $("#" + options.id).modal();
    };

    $.ajaxSetup({
        "beforeSend" : function(jqXHR, settings) {
            $(".icon_loading").html('<div class="pull-right btn btn-default" style="margin-right: 5px;"><i class="fa fa-spin fa-refresh fa-2x"></i> Processando ...</div>');
        },
        "error": function(jqXHR, textStatus, errorThrown) {
            $.clearAllMessage();
            $.addErrorMessage(jqXHR.responseText);
            //$.addErrorMessage("Falha ao Efetuar Requisição Ajax!");
        },
        "complete": function(jqXHR, textStatus) {
            $(".icon_loading").children().remove();
        }
    });
    
    $.paginacao = function(obj) {
        html = '';
        
        var div_container = $('<div>');
        var div_principal = $('<div>', { "class" : "col-md-8" }).appendTo(div_container);
        var total_page = 0;
        if (obj.total_page) {
            total_page = obj.total_page;
        }
        var atual_page = 1;
        if (obj.page) {
            atual_page = obj.page;
        }
        if (total_page > 1) {
            var page_range = 10;
            if (total_page > page_range) {
                var page_range_inicio = 1;
                if (atual_page > 1) {
                    page_range_inicio = atual_page - parseInt(page_range / 2);
                    if (page_range_inicio <= 0) {
                        page_range_inicio = 1;
                    }
                }
                var page_range_fim = page_range_inicio + page_range;
                if (page_range_fim > total_page) {
                    page_range_fim = total_page;
                    page_range_inicio = page_range_fim - page_range;
                }
            } else {
                var page_range_inicio = 1;
                var page_range_fim = total_page;
            }
            var div_text_center = $('<div>', { "class" : "pull-left" }).appendTo(div_principal);
            var ul_pagination = $('<ul>', { "class" : "pagination" }).appendTo(div_text_center);

            if (atual_page > 1) {
                $('<li><a href="javascript:selecionaPagina(' + (atual_page - 1) + ');">«</a></li>').appendTo(ul_pagination);
            } else {
                $('<li class="disabled"><a href="#">«</a></li>').appendTo(ul_pagination);
            }

            for (var page = page_range_inicio; page <= page_range_fim; page++) { 
                if (page == atual_page) {
                    $('<li class="active"><a href="#">' + page + ' <span class="sr-only">(current)</span></a></li>').appendTo(ul_pagination);
                } else {
                    $('<li><a href="javascript:selecionaPagina(' + page + ');">' + page + '</a></li>').appendTo(ul_pagination);
                }
            }
            if (atual_page < total_page) {
                $('<li><a href="javascript:selecionaPagina(' + (atual_page + 1) + ');">»</a></li>').appendTo(ul_pagination);
            } else {
                $('<li class="disabled"><a href="#">»</a></li>').appendTo(ul_pagination);
            }
            html += div_container.html();
        }
        if (obj.total_registros && (obj.total_registros > 0)) {
            html += '<div class="pull-right label label-info"><h5><strong>' + obj.total_registros + '</strong> Registro(s) Encontrado(s).</h5></div>';
        }
        return html;
    }
    $(":file").filestyle({
        buttonText : ' Upload',
        buttonName : 'btn-default'
    });
    
    $('#content').slimScroll({
        height: 'auto'
    });
    
    
});

function pesquisar() {
    var form = $("#pesquisa_form");
    if (form.length) {
        var visivel = form.is(":visible");
        if (visivel) {
            form.hide();
        } else {
            form.show();
            form.find(".pesquisa_field").first().focus();
        }
    }
}

function salvarFormulario(form_id) {
    $("#" + form_id).submit();
}