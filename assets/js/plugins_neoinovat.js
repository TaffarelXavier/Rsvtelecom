/**
 * @autor Taffarel Xavier
 * @copy 2015-2016
 */
var _fNome, _fSize, _fTipo, _fLastModifiedDate;
var _fFile = new Object();
//=======================================
//      ESTE PLUGIN VALIDA DATAS
//=======================================
(function ($) {

    $.fn.validarData = function (options) {

        /*O elemento princial, sem funcionalidades (kkk)*/
        var elemento = $(this);
        /**
         * <p>Definições padrões</p>
         * @type type
         */
        var defaults = {
            t_mascara: '##/##/####',
            t_regex: /(^(((0[1-9]|[12][0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/gmi,
            t_permitir_ano_anterior: false
        };
        /*Função do JQuery, extends*/
        var setting = $.extend({}, defaults, options);
        /*Função para mensagens*/
        function mensagens(mensagem) {
            alert(mensagem);
            elemento.select();
            elemento.val("");
        }

        /*Retorna o próprio elemento*/
        return this.each(function () {

           /*Insere a máscara*/
            $(this).mask(setting.t_mascara);
            /*Evento ao sair do elemento*/
            $(this).blur(function () {

                //Neste ponto se o valor do objeto t_permitir_ano_anterior= false então não é permitido colocar 
                //anos anteriores a este.
                if (setting.t_permitir_ano_anterior === false) {

                    var div = $(this).val().split('/');
                    var data = new Date();
                    //Exemplo: ano do input for menor que o ano do computador do cliente
                    if (div[2] < data.getFullYear()) {
                        mensagens('O ano não pode ser menor que ' + data.getFullYear());
                        return false;
                    }
                }
                /*
                 //Faz uma regular expressão para validar a entrada do usuário
                 var patt = new RegExp(setting.t_regex);
                 
                 //Testa esta entrada com a string do input
                 var res = patt.test($(this).val());
                 //Testa esta entrada final, com a saída para o cliente
                 if (res === false) {
                 mensagens("Data Inválida.");
                 }
                 */
            });
        });
    };
}(jQuery));

(function ($) {

    var f = false;
    /**
     * 
     * @param {type} texto
     * @returns {plugin.select_L25.$.fn@call;each}
     */
    $.fn._neoPluginSelect = function (texto) {

        var elemt = $(this);
        if (texto == undefined || texto == "") {
            texto = "Selecione...";
        }

        var defaults = {
            border: '1px solid #4d90fe'
        };
        var btnId = "btn" + Math.floor((Math.random() * 100) + 1);
        var buttons = "<a id='" + btnId + "' class='btn blue'><i class='icon-square'></i> Selecionar Todos</a><br/>";
        elemt.prepend(buttons);
        var _b = $("#" + btnId);
        _b.addClass("btn").addClass("").addClass("red");
        var _select = $(this).find("select");
        _select.attr('multiple', true);
        var novoId = "neoInovatSelect" + Math.floor((Math.random() * 100) + 1);
        _select.attr("id", novoId).css('border', defaults.border);
        return this.each(function () {

            var option = document.createElement("optgroup");
            option.label = texto;
            option.text = "";
            _select.prepend(option);
            elemt.css("border", "0px solid red");
            _b.click(function () {
                if (f == false) {
                    $('#' + novoId + ' option').attr('selected', true);
                    _b.html("<i class='icon-check-square'></i> Remover Todos ");
                    f = true;
                } else {
                    $('#' + novoId + ' option').attr('selected', false);
                    _b.html("<i class='icon-square'></i> Selecionar Todos");
                    f = false;
                }
            });
        });
    };
}(jQuery));
/**
 * 
 * @param {type} value
 * @param {type} array
 * @returns {Boolean}
 */
function in_array(value, array) {
    return (array.indexOf(value) !== -1);
}

/**
 * Plugin neoUpload
 * @param {type} $
 * @returns {undefined}
 */
(function ($) {
    /**
     * 
     * @param {type} options
     * @returns {plugin.select_L77.$.fn@call;each}
     */
    $.fn._neoPluginUpload = function (options) {

        var elem = $(this);

        isValido = true;

        elem.attr("title", "Clique para adicionar um arquivo");

        inputElement = fileName = undefined;
        /**
         * 
         * @param {type} value
         * @param {type} array
         * @returns {Boolean}
         */
        function in_array(value, array) {
            return (array.indexOf(value) !== -1);
        }

        //Definições Defaults
        var defaults = {
            name: "file",
            id: "file",
            mensagem: {
                incluir: "Clique para incluir um arquivo",
                alterar: "Clique para alterar este arquivo"
            },
            evenChange: function (e) {
                e = isValido;
            },
            retornaInputElement: function () {
            },
            accept: ".pdf,.docx,.jpeg,.png,.jpg",
            tiposPermitidos: ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'video/mp4',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/plain', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/force-download'],
            tamanhoPermitido: 2097152 //2MB,
        };
        function bytesToSize(bytes) {
            if (bytes < 1024) {
                return Math.round(bytes) + "Bytes";
            } else if (bytes < 1048576) {
                return Math.round((bytes / 1024).toFixed(3)) + "KB";
            } else if (bytes < 1073741824) {
                return Math.round((bytes / 1048576).toFixed(3)) + "MB";
            } else {
                return Math.round((bytes / 1073741824).toFixed(3)) + "GB";
            }
        }

        var validaUpload = function (element, _defts, tamanho) {
            var txt = "";
            if ('files' in element) {
                if (element.files.length == 0) {
                    txt = "Selecione um ou mais arquivos";
                } else {
                    for (var i = 0; i < element.files.length; i++) {
                        txt += "<br><strong>" + (i + 1) + ". file</strong><br>";
                        var file = element.files[i];
                        if ('name' in file) {
                            txt += "name: " + file.name + "<br>";
                        }
                        if ('type' in file) {
                            console.log(file);
                            console.log(_defts.tiposPermitidos);
                            console.log(file.type);
                            if (in_array(file.type, _defts.tiposPermitidos) === false) {
                                element.value = '';
                                alert("O tipo do arquivo não é permitido.\n\nOs tipos válidos teminam com as extensões: " + defaults.accept + "\n\nNome do arquivo: " + file.name +
                                        "\n\nTamanho: " + bytesToSize(file.size));
                                isValido = false;
                                return false;
                            } else {
                                isValido = true;
                            }
                        }
                        if ('size' in file) {
                            if (file.size > _defts.tamanhoPermitido) {
                                element.value = '';
                                alert("O tamanho do arquivo excede o tamanho permitido.\n\nTamanho permitido pelo sistema: " + tamanho + "\n" +
                                        "\nTamanho do arquivo enviado: " + bytesToSize(file.size));
                                isValido = false;
                                return false;
                            } else {
                                isValido = true;
                            }
                            txt += "size: " + bytesToSize(file.size) + "\n";
                        }
                    }
                }
            } else {
                if (element.value == "") {
                    txt += "Selecione um ou mais arquivos.";
                } else {
                    txt += "A propriedade file não é suportada neste navegador";
                    txt += "<br>The path of the selected file: " + element.value;
                }
            }
            return txt;
        };
        var setting = $.extend({}, defaults, options);
        return this.each(function () {

            var _id = 'uploadFile' + Math.floor((Math.random() * 100) + 1);
            var label1 = "<label for='" + _id + "' class='neo_label_upload bold' ></label>";
            var label2 = "<label for='" + _id + "'class='neo_label_filename bold' ></label>";
            var file = "<input type='file' accept='" + setting.accept + "'  name='" + setting.name + "' id='" + _id + "' />";
            elem.append([label2, label1, file]);
            inputElement = elem.find("input[type='file']");
            inputElement.hide();
            if (elem.attr("class") !== "upload") {
                elem.addClass("upload");
            }

            inputElement.change(function (isVal) {
                validaUpload(this, setting, bytesToSize(setting.tamanhoPermitido));
                fileName = $(this).val().split('\\').pop();
                $(".neo_label_filename").html('<span class="text-info" style=\'left:0px;text-align:left;top:2px;\'>' + fileName + '</span>');
                isVal = isValido;
                if (isVal == true) {
                    setting.evenChange(fileName, isVal);
                }
            });
            inputElement.change(function (ev) {
                var fileInfo = ev.target.files;
                if (ev.target.value == '') {
                    _fTipo = _fNome = _fSize = _fLastModifiedDate = undefined;
                } else {
                    _fTipo = fileInfo[(ev.target.files.length - 1)].type;
                    _fNome = fileInfo[(ev.target.files.length - 1)].name;
                    _fSize = fileInfo[(ev.target.files.length - 1)].size;
                    _fLastModifiedDate = fileInfo[(ev.target.files.length - 1)].lastModifiedDate;
                    if (_fTipo == '') {
                        var getExt = _fNome.split('.').pop();
                        _fTipo = 'O tipo é desconhecido. Mas sua extensão é: ' + getExt;
                    }
                    _fFile['name'] = _fNome;
                    _fFile['type'] = _fTipo;
                    _fFile['size'] = bytesToSize(_fSize) + '(' + _fSize + ' bytes)';
                    _fFile['lastModifiedDate'] = _fLastModifiedDate;
                }

            });
            setting.retornaInputElement(inputElement);
            elem.find(".neo_label_upload").mouseover(function () {
                $(this).html("<span class='text-info' style='position:absolute;left:0px;text-align:left;top:2px;'>\n\Clique para escolher...<span>");
            }).mouseout(function () {
                $(this).html("<span class='text-info'><span>");
            });
        });
    };
}(jQuery));
/**
 * Plugin plugin_alert
 * @param {type} $
 * @returns {undefined}
 */
(function ($) {

    /**
     * 
     * @param {type} options
     * @returns {plugin.select_L158.$.fn@call;each}
     */
    $.fn._neoPluginAlert = function (options) {

        var elem = $(this);
        var _html, mensagem;
        var defaults = {
            mensagem: "Mensagem...",
            tipoCor: "warning", //Prováveis: warning, success, info e error
            icon: "icon-exclamation-sign", // icon-info-sign,icon-exclamation-sign,icon-warning-sign, icon-ban-circle, icon-question-sign
            tamanho: "medio",
            link: "./?exe=view",
            btnCloseVisivel: 'close'
        };
        function Main(def) {

            if (elem.text() == '' && def.mensagem != 'Mensagem...')
            {
                mensagem = def.mensagem;
            } else if (elem.text() != '' && def.mensagem == 'Mensagem...') {
                mensagem = elem.html();
            } else if (elem.text() == '' && def.mensagem != 'Mensagem...') {
                mensagem = def.mensagem;
            } else {
                mensagem = elem.html();
            }

            if (def.tamanho == "grande") {

                _html = "<div class='row-fluid text-center'><div class='span12'><div class='alert alert-block alert-" + def.tipoCor + " fade in' style = 'padding:10px 25px;' ><a href='" + def.link + "' class='" + def.btnCloseVisivel + "' data-dismiss='alert'></a><br><h4 class='alert-heading' style='padding:0px;margin:0px;font-size: 20px;line-height:30px;' ><i class='" + def.icon + "'></i>&nbsp" + mensagem + " </h4><br/></div></div></div>";
            } else if (def.tamanho == "medio") {
                _html = "<div class='row-fluid text-center'><div class='span2'></div><div class='span8'><div class='alert alert-block alert-" + def.tipoCor + " fade in' style = 'padding:10px 25px;' ><a href='" + def.link + "' class='" + def.btnCloseVisivel + "' data-dismiss='alert'></a><br><h4 class='alert-heading' style='padding:0px;margin:0px;font-size: 20px;line-height:30px;' ><i class ='" + def.icon + "'></i>&nbsp" + mensagem + "</h4><br/></div></div><div class='span2'></div></div>";
            } else {
                _html = "<div class='row-fluid text-center'><div class='span3'></div><div class='span6'><div class='alert alert-block alert-" + def.tipoCor + " fade in' style = 'padding:10px 25px;' ><a href='" + def.link + "' class='" + def.btnCloseVisivel + "' data-dismiss='alert'></a><br><h4 class='alert-heading' style='padding:0px;margin:0px;font-size: 20px;line-height:30px;' ><i class ='" + def.icon + "'></i>&nbsp" + mensagem + "</h4><br/></div></div><div class='span3'></div></div>";
            }
        }

        //Main(defaults);

        var settings = $.extend({}, defaults, options);
        return this.each(function () {
            Main(settings);
            elem.html(_html);
        });
    };
}(jQuery));
/**
 * Verifica se a data do usuário é menor que a data local
 * @param {type} d A data do usuário
 * @param {type} h A hora do usuáiro, geralmente um input com.
 * @returns {Boolean} Retorna true se a data do usuário for menor ou igual a do sistema.
 */

function varificarData(d, h) {

    var data = $(d).val().split("/");
    var hora = $(h).val().split(":");
    var userDate = new Date(data[2], (data[1]), data[0], hora[0], hora[1]);
    var systemData = new Date();
    var arrS = systemData.toLocaleDateString().split("/");
    var hArr = systemData.toLocaleTimeString().split(":");
    var novaData = new Date(arrS[2], arrS[1], arrS[0], hArr[0], hArr[1]); //Ano, mes, dias, hora, minuto, seg

    return (userDate.getTime() <= novaData.getTime()) ? true : false;
}

/**
 * Verifica se a data do usuário é menor que a data local
 * @param {type} d A data do usuário
 * @returns {Boolean} Retorna true se a data do usuário for menor ou igual a do sistema.
 */
function dataIsMenorAsString(d) {

    var data = d.split("/");
    var systemData = new Date();
    var dataDoUsuario = new Date(data[2], (data[1]), data[0], systemData.getHours(), systemData.getMinutes());
    var arrS = systemData.toLocaleDateString().split("/");
    var hArr = systemData.toLocaleTimeString().split(":");
    var novaData = new Date(arrS[2], arrS[1], arrS[0], hArr[0], hArr[1]); //Ano, mes, dias, hora, minuto, seg

    return (dataDoUsuario.getTime() <= novaData.getTime()) ? true : false;
}

//Adiciona zero em números < 10
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}


(function ($) {

    /**
     * <p>Botão para voltar</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L351.$.fn@call;each}
     */
    $.fn._neoPluginBtnVoltar = function (options) {

        //Elemento principail
        var elem = $(this);
        /**
         * Defaults Values
         * @type type
         */
        var defaults = {
            texto: "Voltar",
            cor: "green",
            tamanho: "",
            direcao: "../",
            hrVisible: true,
            float: "float"
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {

            elem.addClass("btn " + settings.cor + " " + settings.tamanho + " ")
                    .css("float", settings.float)
                    .attr({href: settings.direcao})
                    .text(settings.texto)
                    .prepend("<i class='icon-arrow-left'></i>&nbsp;");
            if (settings.hrVisible === true) {
                // elem.append("<hr style='border:0;border-top:1px solid #ccc' />");
            }
        });
    };
}(jQuery));
(function ($) {

    /**
     * <p>Modal</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L373.$.fn@call;each}
     */
    $.fn._neoPluginModal = function (options) {

        //Elemento principail
        var elem = $(this);
        var closeWithESC = false;
        /**
         * Defaults Values
         * @type type
         */
        var defaults = {
            texto: "Voltar"
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {

            /**
             * Fecha o modal inicialmente quando a págian é carregada
             */
            if (options === undefined || options === '' || options === 'hide') {
                elem.hide();
                closeWithESC = false;
            } else if (options === 'show') {//Mostra o modal
                elem.show();
                closeWithESC = true;
            }

            /**
             * Esta classe serve para abrir o modal
             */
            $('.abrir-modal').click(function () {
                var modalId = $(this).attr('href');
                closeWithESC = true;
                $(modalId).show();
                return false;
            });
            /**
             * Se o usuário clicar em abrir modal
             * Pressionando a tecla ESC do teclado para fechar o modal
             * @param {type} e
             * @returns {undefined}
             */

            window.onkeyup = function (e) {
                if (closeWithESC == true) {
                    if (e.keyCode === 27) {
                        elem.hide();
                    }
                }
            };
            /**
             * Pesquisa pelo elemento bottão com o atributo [aria-hidden='true']
             * Serve para fechar o modal
             */
            elem.find(".modal-header [aria-hidden='true']").click(function () {
                closeWithESC = false;
                elem.hide();
            });
            /**
             * Pesquisa pelo elemento bottão com o atributo [data-close-modal='true']
             * Serve para fechar o modal
             */
            elem.find(".neoinovat-modal-footer [data-close-modal='true']").click(function () {
                closeWithESC = false;
                elem.hide();
            });
        });
    };
}(jQuery));
//===================================================
//          Pega as informações de um arquivo        
//          @type @arr;fileInfo@pro;name             
//===================================================

(function ($) {
    $.fn._neoFileInfo = function () {

        var _element = $(this);
        return this.each(function () {

            function bytesToSize(bytes) {
                if (bytes < 1024)
                    return Math.round(bytes) + " Bytes ";
                else if (bytes < 1048576)
                    return Math.round((bytes / 1024).toFixed(3)) + " KB ";
                else if (bytes < 1073741824)
                    return Math.round((bytes / 1048576).toFixed(3)) + " MB ";
                else
                    return Math.round((bytes / 1073741824).toFixed(3)) + " GB ";
            }

            _element.change(function (e) {
                var fileInfo = e.target.files;
                _fTipo = fileInfo[(e.target.files.length - 1)].type;
                _fNome = fileInfo[(e.target.files.length - 1)].name;
                _fSize = fileInfo[(e.target.files.length - 1)].size;
                _fLastModifiedDate = fileInfo[(e.target.files.length - 1)].lastModifiedDate;
                if (_fTipo == '') {
                    var getExt = _fNome.split('.').pop();
                    _fTipo = 'O tipo é desconhecido. Mas sua extensão é: ' + getExt;
                }
                _fFile['name'] = _fNome;
                _fFile['type'] = _fTipo;
                _fFile['size'] = bytesToSize(_fSize) + '(' + _fSize + ' bytes)';
                _fFile['lastModifiedDate'] = _fLastModifiedDate;
            });
        });
    };
}(jQuery));
var handleSidebarToggler = function () {

    var container = $(".page-container");
    //Verifica se uma função existe
    if (typeof $.cookie != 'function')
    {
        console.log('%c' + decodeURIComponent(escape('A função $.cookie não foi definida.\nAdicione o arquivo javascript que contenha essa função.'.toString())), 'font-size:18px;color:red;');
        return false;
    }

    if ($.cookie('sidebar-closed') == 1) {
        container.addClass("sidebar-closed");
    }

    // handle sidebar show/hide
    $('.page-sidebar .sidebar-toggler').click(function () {
        $(".sidebar-search").removeClass("open");
        var container = $(".page-container");
        if (container.hasClass("sidebar-closed") === true) {
            container.removeClass("sidebar-closed");
            $.cookie('sidebar-closed', null);
        } else {
            container.addClass("sidebar-closed");
            $.cookie('sidebar-closed', 1);
        }
    });
    // handle the search bar close
    $('.sidebar-search .remove').click(function () {
        $('.sidebar-search').removeClass("open");
    });
};
//Valida uma string como JSON
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

handleSidebarToggler();
(function ($) {

    /**
     * <p>Botão para voltar</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L351.$.fn@call;each}
     */
    $.fn._neoBeforeUnload = function (editar, mensagem, options) {

        estaEditando = false;
        /**
         * Defaults Values
         * @type type
         */
        var defaults = {
            texto: "Voltar"
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {

            $('input,textarea').keyup(function () {
                estaEditando = true;
            });
            if (mensagem === undefined) {
                mensagem = "Cemvs";
            }

            window.onbeforeunload = function () {
                if (estaEditando == true && editar == false || options != undefined) {
                    return mensagem;
                }
            };
        });
    };
}(jQuery));
function titleize(text) {
    var words = text.toLowerCase().split(" ");
    for (var a = 0; a < words.length; a++) {
        var w = words[a];
        words[a] = w[0].toUpperCase() + w.slice(1);
    }
    return words.join(" ");
}

/**
 * <p>Selecionar valores do OPTION de um SELECT Array</p>
 * @param {array} _array
 * @param {Seletor} _seletor
 * @returns {undefined}
 */
function _neoSelecionarValoresArray(_array, _seletor) {

    _array.forEach(function (item) {
        $(_seletor + ' option[value="' + item + '"]').attr({selected: true});
    });
    return true;
}

function _neoGetValuesSelect(selector) {
    $(selector).change(function () {

        var arr = $(this).find("option:selected");
        var rr = [];
        for (x = 0; x < arr.length; ++x) {
            rr[x] = arr[x].value;
        }
        var _join = rr.join(',');
        return _join;
    });
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

(function ($) {

    /**
     * <p>Substitui vírgula por ponto.</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L351.$.fn@call;each}
     */
    $.fn._neoReplaceVirgulaPorPonto = function (options) {

        var _this = $(this);
        return this.each(function () {

            $(_this).keyup(function () {
                var val = $(this).val().replace(',', '.');
                $(this).val(val);
                if (isNumber($(this).val()) == false) {
                    $(this).val('');
                }
            }).blur(function () {
                var val = $(this).val().replace(',', '.');
                $(this).val(val);
                if (isNumber($(this).val()) == false) {
                    $(this).val('');
                }
            });
        });
    };
}(jQuery));
(function ($) {

    /**
     * <p>Substitui vírgula por ponto.</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L351.$.fn@call;each}
     */
    $.fn._neoBtnDisabled = function (options) {

        var _this = $(this);
        var defaults = {
            disabled: true,
            mensagem: "Salvando, aguarde por favor...",
            icon: "save"
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {
            if (options != false) {
                $(_this).attr("disabled", settings.valor).html('<i class="icon-' + settings.icon + '"></i>' + settings.mensagem);
            } else {
                _this.click(function () {
                    $(this).attr("disabled", true);
                });
            }
        });
    };
}(jQuery));
//====================================
//          MENU DE CONTEXTO
//====================================
(function ($) {

    /**
     * <p>Substitui vírgula por ponto.</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L351.$.fn@call;each}
     */
    $.fn._neoMenuDeContexto = function (options) {

        var defaults = {
            enderecos: {
                "inicio": {
                    text: "Início",
                    href: "../",
                    target: '_top'
                },
                "Horario": {
                    text: "Horário Eletrônico",
                    href: "../horario-eletronico",
                    target: '_top'
                },
                "Comunicados": {
                    text: "Comunicados",
                    href: "../comunicados",
                    target: '_top'
                },
                "Calendario": {
                    text: "Calendário Escolar",
                    href: "../calendario-escolar",
                    target: '_top'
                },
                "Config": {
                    text: "Configurações",
                    href: "?exe=configuracoes",
                    target: '_top'
                },
                "Alunos": {
                    text: "Alunos",
                    href: "?exe=alunos",
                    target: '_top'
                },
                "Professores": {
                    text: "Professores",
                    href: "?exe=professores",
                    target: '_top'
                },
                "Disciplinas": {
                    text: "Disciplinas",
                    href: "?exe=disciplinas",
                    target: '_top'
                },
                "Turmas": {
                    text: "Turmas",
                    href: "?exe=turmas",
                    target: '_top'
                }
            }
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {

            var strLinks = "";
            for (var key in settings.enderecos) {

                if (!settings.enderecos.hasOwnProperty(key))
                    continue;
                var obj = settings.enderecos[key];
                strLinks += "<a href='" + obj.href + "' target='" + obj.target + "'>" + obj.text + "</a>";
            }

            var string = "<div id='t-menucontext'>" + strLinks + "<a href='javascript:window.location.reload();'>Recarregar</a></div>";
            $('body').click(function () {
                $('#t-menucontext').remove();
            });
            window.oncontextmenu = function (ev) {

                $('#t-menucontext').remove();
                $('body').prepend(string);
                var x = screen.availWidth / 2;
                if (ev.clientY > (screen.availHeight / 2)) {
                    if (ev.clientX > x) {
                        $('#t-menucontext').css({top: ev.clientY - $('#t-menucontext').height(), left: ev.clientX - $('#t-menucontext').width()});
                    } else {
                        $('#t-menucontext').css({top: ev.clientY - $('#t-menucontext').height(), left: ev.clientX});
                    }
                } else {
                    if (ev.clientX > x) {
                        $('#t-menucontext').css({top: ev.clientY, left: ev.clientX - $('#t-menucontext').width()});
                    } else {
                        $('#t-menucontext').css({top: ev.clientY, left: ev.clientX});
                    }

                }

                return false;
            };
        });
    };
}(jQuery));
(function ($) {

    /**
     * <p>Substitui vírgula por ponto.</p>
     * @param {type} options
     * @returns {plugins_neoinovat_L351.$.fn@call;each}
     */
    $.fn._neoLoading = function (options) {

        var _this = $(this);
        var defaults = {
            disabled: true,
            mensagem: "Salvando, aguarde por favor...",
            icon: "save"
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {
            var url_imagem = window.location.origin + '/imagens/loading.gif';
            if (options == true || options == undefined) {
                _this.html("<img src='" + url_imagem + "' style='' />\n\
 <span style='position:relative;top:2px;color:red;text-shadown:0px 1px 0px rgba(0,0,0,0.5);'>Carregando, aguarde por favor...</span>");
            } else if (options == false || options == '') {
                _this.html('');
            }
        });
    };
}(jQuery));
/**
 * 
 * @type type
 */
var TX_Array = {
    rate: function rate(selector) {

        (function ($) {

            /**
             * <p>Substitui vírgula por ponto.</p>
             * @param {type} options
             * @returns {plugins_neoinovat_L351.$.fn@call;each}
             */
            $.fn._neoRating = function (options) {

                var _this = $(this);
                var defaults = {
                    disabled: true,
                    mensagem: "Salvando, aguarde por favor...",
                    icon: "save"
                };
                var settings = $.extend({}, defaults, options);
                return this.each(function () {

                    _string = '<form enctype="multipart/form-data" action="" method="post">' +
                            '<p style="font-size:18px;">Avalie este fórum de forma geral.</p>' +
                            '<div class="_rating"></div>' +
                            '<div><span class="rating"><span class="star star-5" data-start="star-5"></span><span class="star star-4" data-start="star-4"></span><span class="star star-3" data-start="star-3"></span><span class="star star-2" data-start="star-2"></span><span class="star star-1" data-start="star-1"></span></span></div>' +
                            '<textarea placeholder="Insira algum comentário."></textarea><br/>' +
                            '<button class="btn green">Avaliar <i class="icon-send"></i></button>' +
                            '</form>';
                    _this.html(_string);
                    $('.star').click(function () {
                        dataStart = $(this).attr("data-start");
                        $('.' + dataStart).css('background', 'red');
                    });
                });
            };
        }(jQuery));
        $(selector)._neoRating();
    },
    txArr: [],
    /**
     * 
     * @param {type} _Array
     * @param {type} _searchValue
     * @returns {unresolved}
     */
    removerItem: function removerItemFromArray(_Array, _searchValue) {
        index = _Array.indexOf(_searchValue);
        if (index > -1) {
            _Array.splice(index, 1);
        }
        return _Array;
    },
    /**
     * 
     * @param {type} x
     * @returns {Boolean}
     */
    isArray: function isArray(x) {
        return x.constructor.toString().indexOf('Array') > -1;
    },
    /**
     * 
     * @param {type} Array
     * @param {type} valor
     * @returns {Boolean}
     */
    inArray: function inArray(Array, valor) {
        return (Array.indexOf(valor) == -1) ? false : true;
    },
    /**
     * 
     * @param {type} _array
     * @param {type} _seletor
     * @returns {Boolean}
     */
    selectIndexPorValorArray: function _neoSelecionarValoresArray(_array, _seletor) {

        _array.forEach(function (item) {
            $(_seletor + ' option[value="' + item + '"]').attr({selected: true});
        });
        return true;
    },
    /**
     * 
     * @param {Array} x O Array de entrada
     * @param {strgng} delimitador O delimitador
     * @returns {Array}
     */
    txSplit: function atrsss(x, delimitador) {
        return x.join(delimitador);
    },
    valor: 1,
    validarInput: function validateQty(evt) {
        var key = window.event ? evt.keyCode : evt.which;
        if (evt.keyCode == 8 || evt.keyCode == 46
                || evt.keyCode == 37 || evt.keyCode == 39) {
            return true;
        } else if (key < 48 || key > 57) {
            return false;
        } else
            return true;
    },
    'replace_caracteres_especiais': function replace_caracteres_especiais(string) {
        var string = string.replace(/\*(.+?)\*/gmi, "<b>$1</b>");
        string = string.replace(/\_(.+?)\_/gmi, "<i>$1</i>");
        string = string.replace(/\_\*(.+?)\_\*/gmi, "<b><i>$1</i></b>");
        string = string.replace(/\~(.+?)\~/gmi, "<strike>$1</strike>");
        string = string.replace(/\[(.+?)\]/gmi, "<sup>$1</sup>");
        string = string.replace(/\@(.+?)\@/gmi, "<sub>$1</sub>");
        string = string.replace(/\#(.+?)\#/gmi, "<mark>$1</mark>");
        string = string.replace(/\#((.|\s)*)\#/gmi, "<mark>$1</mark>");
        string = string.replace(/(https:\/\/(www\.|.*?\/)?|http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/gmi, "<a href='$1$4$5'  style=\"color:#4485f6;\" title=\"Clique para abrir\" target=\"_blank\">$1$4$5</a>");
        string = string.replace(/\\n/gmi, "<br/>");
        return string;
    },
    'replace_html_especiais': function replace_html_especiais(string) {
        var string = string.replace(/\<b\>(.*?)\<\/b\>/g, '*$1*');
        string = string.replace(/\<i\>(.*)\<\/i\>/gmi, '_$1_');
        string = string.replace(/\<b\>\<i\>(.*?)\<\/i\>\<\/b\>/gmi, '_*$1*_');
        string = string.replace(/\<strike\>(.*?)\<\/strike\>/gmi, '~$1~');
        string = string.replace(/\<sup\>(.*?)\<\/sup\>/gmi, '[$1]');
        string = string.replace(/\<sub\>(.*?)\<\/sub\>/gmi, '@$1@');
        string = string.replace(/\<mark\>(.*?)\<\/mark\>/gmi, '#$1#');
        string = string.replace(/<a.*?\>(.*?)\<\/a>/gmi, '$1');
        string = string.replace(/\<br\>|\<br\\\>/gmi, '\\n');
        return string;
    },
    'getAnchorTexts': function getAnchorTexts(htmlStr) {
        var div,
                anchors,
                i,
                texts;
        div = document.createElement('div');
        div.innerHTML = htmlStr;
        anchors = div.getElementsByTagName('a');
        texts = [];
        for (i = 0; i < anchors.length; i += 1) {
            texts.push(anchors[i].text);
        }
        return texts;
    },
    'IsJsonString': function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    },
    'youtubeUrlParser': function (url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    },
    'getTextTitle': function () {
        var title = result.match("<title>(.*?)</title>")[1];
        return title;
    },
    /**
     * <p>Ao colocar um id no primeiro parâmetro, automaticamente é criado um elemento no documento</p>
     * @param {int} _id O Id do elemento 
     * @param {bool} abrir Se for igual a true então é aberto automaticamente
     * @param {int} tempoFechar O tempo para fechar (em segundos);
     * @param {bool} fecharComTempo Se for igual a true fecha com o tempo
     * @param {string} mensagem A mensagem para exibição
     * @returns {bool}
     */
    openModal: function (_id, abrir, tempoFechar, fecharComTempo, mensagem) {

        $('body').append('<div id="' + _id + '"></div>');
        var string = '<div id="modal-' + _id + '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="' + _id + '" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h3 id="myModalLabel3">CEMVS</h3></div><div class="modal-body">' + mensagem + '</div><div class="modal-footer"><button data-dismiss="modal" class="btn red" id="excluirProfessores">Fechar</button></div></div>';
        $('#' + _id).append(string);
        if (abrir == true) {
            $('#modal-' + _id).modal('show');
            i = 0;
            if (fecharComTempo == true) {
                var f = setInterval(function () {
                    ++i;
                    if (i == tempoFechar) {
                        $('#modal-' + _id).modal('hide');
                        $('#' + _id).remove();
                        window.clearInterval(f);
                    }
                }, 1000);
            }
        }
        return false;
    }
};
/**
 * Plugin plugin_alert
 * @param {type} $
 * @returns {undefined}
 */
(function ($) {

    /**
     * 
     * @param {type} options
     * @returns {plugin.select_L158.$.fn@call;each}
     */
    $.fn._neoPluginModal = function (options) {

        var elem = $(this);
        var defaults = {
            mensagem: "Mensagem...", /*A mensagem a ser exibida*/
            abrir: false, /*Se for igual a falso o plugin abre fechado o modal*/
            tempo: 3, /*Tempo para fechar o modal*/
            fecharComTempo: true
        };
        //Main(defaults);

        var settings = $.extend({}, defaults, options);
        return this.each(function () {

            var _id = elem.attr('id');
            var d = elem[0].ownerDocument.lastModified;
            if (undefined == _id) {
                _id = elem[0].className + '' + d.replace(/\/+|\s+|\:/gmi, '');
            }

            var string = '<div id="modal-' + _id + '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="' + _id + '" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h3 id="myModalLabel3">CEMVS</h3></div><div class="modal-body">' + settings.mensagem + '</div><div class="modal-footer"><button data-dismiss="modal" class="btn red" id="excluirProfessores">Fechar</button></div></div>';
            elem.append(string);
            if (settings.abrir == true) {
                $('#modal-' + _id).modal('show');
                i = 0;
                if (settings.fecharComTempo == true) {
                    var f = setInterval(function () {
                        ++i;
                        if (i == settings.tempo) {
                            $('#modal-' + _id).modal('hide');
                            elem.remove();
                            window.clearInterval(f);
                        }
                    }, 1000);
                }
            }
        });
    };
}(jQuery));

/**
 * Classe de publicações
 * @type type
 */
var Publicacoes = {
    pasteHtmlAtCaret: function (html) {
        var sel, range;
        if (window.getSelection) {
            // IE9 and non-IE
            sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                range = sel.getRangeAt(0);
                range.deleteContents();

                // Range.createContextualFragment() would be useful here but is
                // only relatively recently standardized and is not supported in
                // some browsers (IE9, for one)
                var el = document.createElement("div");
                el.innerHTML = html;
                var frag = document.createDocumentFragment(), node, lastNode;
                while ((node = el.firstChild)) {
                    lastNode = frag.appendChild(node);
                }
                range.insertNode(frag);

                // Preserve the selection
                if (lastNode) {
                    range = range.cloneRange();
                    range.setStartAfter(lastNode);
                    range.collapse(true);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
        } else if (document.selection && document.selection.type != "Control") {
            // IE < 9
            document.selection.createRange().pasteHTML(html);
        }
    },
    /**
     * 
     * @param {type} _elem
     * @param {type} _div
     * @returns {undefined}
     */
    insert: function (_elem, _div, _texto) {
        $(_elem).click(function () {
            $(_div).focus();
            Publicacoes.pasteHtmlAtCaret(_texto);
        });
    },
    /**
     * 
     * @param {type} _div
     * @param {type} _texto
     * @returns {undefined}
     */
    elementInsert: function (_div, _texto) {
        $(_div).focus();
        Publicacoes.pasteHtmlAtCaret(_texto);
    },
    /**
     * <p>Remove elementos</p>
     * @param {type} _prefix
     * @param {type} _pb_id
     * @returns {undefined}
     */
    'removerElemento': function (_prefix, _pb_id) {
        $('#' + _prefix + '-' + _pb_id).slideUp('');
    },
    'excluirPublicacao': function () {
        /*Exclui uma publicação*/
        $('#id_btn_excl_publ').click(function () {
            var _pbId = $('#id_inp_public_id').val();
            /*Cria um array com dois índexs. O primeiro [0] é o id da publicação, o segundo [1] é o ID do usuário*/
            var _arrayId = _pbId.split('-');
            Publicacoes.removerElemento('publicacao', _pbId);
            Publicacoes.removerElemento('pbalert', _pbId);
            Publicacoes.removerElemento('div', _pbId);
            Publicacoes.removerElemento('card-separador-horizontal', _pbId);
            $.post('../publicacoes/excluir_publicacao.php', {
                publicacao_id: parseInt(_arrayId[0]),
                aluno_id: parseInt(_arrayId[1])
            }, function (data) {
                if (data == '1') {
                    Publicacoes.carregarFeed();
                } else {
                    //alert(data);
                }
            });
        });
    },
    'compartilharVideoYoutube': function (string) {
        string = '<iframe width="854" height="480" src="https://www.youtube.com/embed/jLA_EU7C6E0" frameborder="0" allowfullscreen></iframe>';
        /*  
         var video_id = string.search.split('v=')[1];
         var ampersandPosition = video_id.indexOf('&');
         if (ampersandPosition != -1) {
         video_id = video_id.substring(0, ampersandPosition);
         }*/

        // Just the regex. Output is in [1].

// For testing.
        var urls = [
            '//www.youtube-nocookie.com/embed/up_lNV-yoK4?rel=0',
            'http://www.youtube.com/user/Scobleizer#p/u/1/1p3vcRhsYGo',
            'http://www.youtube.com/watch?v=cKZDdG9FTKY&feature=channel',
            'http://www.youtube.com/watch?v=yZ-K7nCVnBI&playnext_from=TL&videos=osPknwzXEas&feature=sub',
            'http://www.youtube.com/ytscreeningroom?v=NRHVzbJVx8I',
            'http://www.youtube.com/user/SilkRoadTheatre#p/a/u/2/6dwqZw0j_jY',
            'http://youtu.be/6dwqZw0j_jY',
            'http://www.youtube.com/watch?v=6dwqZw0j_jY&feature=youtu.be',
            'http://youtu.be/afa-5HQHiAs',
            'http://www.youtube.com/user/Scobleizer#p/u/1/1p3vcRhsYGo?rel=0',
            'http://www.youtube.com/watch?v=cKZDdG9FTKY&feature=channel',
            'http://www.youtube.com/watch?v=yZ-K7nCVnBI&playnext_from=TL&videos=osPknwzXEas&feature=sub',
            'http://www.youtube.com/ytscreeningroom?v=NRHVzbJVx8I',
            'http://www.youtube.com/embed/nas1rJpm7wY?rel=0',
            'http://www.youtube.com/watch?v=peFZbP64dsU',
            'http://youtube.com/v/dQw4w9WgXcQ?feature=youtube_gdata_player',
            'http://youtube.com/vi/dQw4w9WgXcQ?feature=youtube_gdata_player',
            'http://youtube.com/?v=dQw4w9WgXcQ&feature=youtube_gdata_player',
            'http://www.youtube.com/watch?v=dQw4w9WgXcQ&feature=youtube_gdata_player',
            'http://youtube.com/?vi=dQw4w9WgXcQ&feature=youtube_gdata_player',
            'http://youtube.com/watch?v=dQw4w9WgXcQ&feature=youtube_gdata_player',
            'http://youtube.com/watch?vi=dQw4w9WgXcQ&feature=youtube_gdata_player',
            'http://youtu.be/dQw4w9WgXcQ?feature=youtube_gdata_player'
        ];

        var i, r, rx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;

        for (i = 0; i < urls.length; ++i) {
            r = urls[i].match(rx);
            console.log(r[1]);
        }

        return true;
    },
    /**
     * Carrega o feed de notícias
     * @param {type} url
     * @param {type} html_result
     * @returns {undefined}
     */
    'carregarFeed': function (url, html_result) {
        $.post(url, function (d) {
            $(html_result).html(d);
        });
    },
    /**
     * 
     * @param {type} min A cada 1000=1 segundo
     * @returns {undefined}
     */
    'updateFeedTimer': function (min) {

        var f = setInterval(function () {

            if (isAudioPlayed == false) {
                Publicacoes.carregarFeed('publicacoes/publicacoes.php', '#get_publicacoes')
            }
            var audios = document.getElementsByTagName('audio');

            for (dx = 0; dx < audios.length; ++dx) {
                if (audios[dx].paused == false) {
                    //
                }
            }
        }, min); /**/
    },
    /**
     * Botão -  Ocultar
     * @returns {undefined}
     */
    'btnOcultarCard': function () {
        $('.pb_ocultar').click(function () {
            var _pbId = $(this).attr('data-pub-id');
            alert(_pbId);
            return false;
        });
    },
    /**
     * Botão - Editar
     * @returns {undefined}
     */
    'btnEditarCard': function () {
        $('.pb_editar').click(function () {
            var _pbId = $(this).attr('data-pub-id');
            alert(_pbId);
            return false;
        });
    },
    /**
     * <p>Quando o usuário clicar sobre o link <b>Comentar</b></p>
     * @returns {undefined}
     */
    'btnCommentCard': function () {
        $('.card-button-comment').click(function () {
            var _thisId = $(this).attr('data-publicacao-id');
            $('#comment-' + _thisId).text('').focus();
        });
    },
    'btnCompartilharPublicacao': function () {
        _publicacaoArrayID = undefined;
        /*Botão - Compartilhar*/
        $('.pb_compartilhar,.card-button-share').click(function () {

            var _pbId = $(this).attr('data-pub-id');
            _publicacaoArrayID = _pbId;
            $('#id_modal_compartilhamento').modal('show');
            $('.class_modal_compartilhamento').html('Carregado, publicação...');
            $.post('../publicacoes/get_dado_publicacao.php',
                    {
                        publicacao_id: _pbId
                    },
                    function (data) {
                        $('.class_modal_compartilhamento').html(data);
                    });
            return false;
        });
    },
    'btnDropDownExcluirPublicacao': function () {

        /*Dropdown - Botão - Excluir*/
        $('.pb_excluir').click(function () {
            /*Pega o id da publicação. Formato. idpublicacao[number]-idalumo[number]*/
            var _pbId = $(this).attr('data-pub-id');
            /*Adiciona o id da publicação dentro do input*/
            $('#id_inp_public_id').val(_pbId);
            /*Abre o modal de confirmação*/
            $('#id_modal_excluir_publicacao').modal('show');
            return false;
        });
    },
    'abrirModal': function () {
        $('.abrirModal').click(function () {
            var crsr = '<div id="alunosQueCompartilharam"></div>';
            $('body').append(crsr);
            var _id = $(this).attr('data-pub-id');
            var string = '<div id="getAlunosCompartilharam">Carregando...</div>';
            $('#alunosQueCompartilharam')._neoPluginModal({
                mensagem: string,
                abrir: true,
                tempo: 10,
                fecharComTempo: false
            });
            $.post('../publicacoes/get_alunos_compartilharam.php', {
                publicacao_id: _id
            }, function (data) {
                string += data;
                $('#getAlunosCompartilharam').html(data);
            });
        });
    },
    /**
     * 
     * @param {type} url
     * @returns {undefined}
     * @example '../views/get_marcacoes.php'
     */
    'getAlunosMarcados': function (url) {
        $('.getAlunosMarcados').click(function () {
            var _thisId = $(this).attr('data-publicacao-id');
            $.post(url, {
                publicacao_id: parseInt(_thisId)
            }, function (data) {
                $('.modalContent').html(data);
            });
        });
    },
    'btnReplyComment': function () {
        $('.card-editor-replay-comment').click(function () {

            var _thisElemtn = $(this);

            var _idEditorComment = _thisElemtn.attr('id');

            var r = _idEditorComment.split('-');

            //var alunoLogadoId = _thisElemtn.attr('data-aluno-id');

            if (_thisElemtn.html().trim() == 'Escreva um comentário...') {
                _thisElemtn.html('').focus();
            }

            var _painelSmiles = $('#painel-smiles-' + r[1] + '-' + r[2]);

            //_painelSmiles.hide();

        }).keyup(function (ev) {

            /*O elemento*/
            var _thisElement = $(this);

            /*O Id do elemento*/
            var _idEditorComment = _thisElement.attr('id');

            var _dataId = $(this).attr('data-id');

            var alunoLogadoId = _thisElement.attr('data-aluno-id');

            if (ev.keyCode == 13) {
                /*Split o Id do elemento Primeiro Index: comment; 1º o Id da publicação; o 2º o id do usuário*/

                var nId = _idEditorComment.split('-');

                nId[3] = _thisElement.html();

                nId[2] = alunoLogadoId;

                var regex = /<img\s+class\=\"(.*?)\"\s+data\-emoji\=\".*?\"\ssrc\=\"\"\salt\=\"alt\"\>/gmi;

                nId[3] = nId[3].replace(regex, '&lt;txicon&gt;$1&lt;/txicon&gt;');

                $.post('publicacoes/models/comentar_publicacao.php', {
                    comment: nId
                }, function (data) {
                    if (data == 1) {
                        $.post('publicacoes/publicacoes_comentarios.php', {pb_id: nId[1]}, function (data) {
                            _thisElement.html('Escreva um comentário...');
                            _thisElement.text('');
                            $('#publicacao-id-' + nId[1]).html(data);
                        });
                    } else {
                        alert(data);
                    }
                });
            }
            return false;
        });
    },
    /**
     * <p>Carrega os dados</p>
     * @param {type} _alunoid
     * @returns {undefined}
     */
    'loadFeedIndividual': function (_alunoid) {
        $.post('views/profile_publicacoes.php', {
            alunoid: _alunoid
        }, function (data) {
            $('#loadFeed').html(data);
        });
    },
    'alterarStatus': function () {
        /**
         * Mostrar barra de botões
         */
        $('#sm_status').keyup(function () {
            $('#sm_btns_status').show();
        });
        /**
         * Cancelar
         */
        $('#sm_btns_sts_cancelar').click(function () {
            $('#sm_btns_status').hide('');
        });

        /*Botão para salvar um status*/
        $('#sm_btns_sts_salvar').click(function () {
            $('#sm_btns_status').hide('');
            $.post('models/alterar_status.php', {
                privacidadeNumber: parseInt($('#card-selected').val()),
                status: $('#sm_status').text().trim(),
                token: $('#tokenId').val(),
                key: $('#keyId').val()
            }, function (data) {
                if (data == '11') {
                    alert('Alterado com sucesso!');
                } else {
                    alert('Ops! Houve um erro. Código ou mensagem do erro:' + data);
                }
            });
        });

    },
    /**
     * 
     * @param {string} selector
     * @param {string} tamanho O tamanho do botão. Exemplo: span2
     * @param {string} _Objeto O tamanho do botão. Exemplo: span2
     * @returns {undefined}
     * @example var _Objeto = {
     item1: {
     nome: ' Público',
     valor: 1
     },
     item2: {
     nome: ' Somente eu',
     valor: 2
     },
     item3: {
     nome: ' Eu e outros alunos',
     valor: 3
     },
     item4: {
     nome: ' Eu e minha turma',
     valor: 4
     }
     };
     */
    'dropDownPrivacidade': function (selector, tamanho, _Objeto, _button) {

        if (_Objeto == undefined) {

            _Objeto = {
                item1: {
                    nome: ' Público',
                    valor: 1
                },
                item2: {
                    nome: ' Somente eu',
                    valor: 2
                },
                item3: {
                    nome: ' Eu e outros alunos',
                    valor: 3
                },
                item4: {
                    nome: ' Eu e minha turma',
                    valor: 4
                }
            };
        }

        _button = (_button == undefined || _button == false) ? 'transparent' : '';

        _strConcat = '<span class="btn-group text-left ' + tamanho + ' "><a href="javascript:void(0);" class="btn bold span12 dropdown-toggle" data-toggle="dropdown" title="" id="card-privacidade" style="background:' + _button + ';"><i class="icon-globe"></i> Público <i class="icon-chevron-down"></i></a><ul class="dropdown-menu" style="padding: 4px;">';

        for (var i in _Objeto) {

            if (_Objeto.hasOwnProperty(i)) {
                _strConcat += '<li><a href="javascript:void(0);" style="margin-right: 0px;display:block;width:auto;" class="card-item-privacidade" data-pub-value="' + _Objeto[i].valor + '"><i class="icon-globe"></i>' + _Objeto[i].nome + '</a></li>\n\n';

            }

        }
        _strConcat += '</ul></span>';

        $(selector).append(_strConcat);

        /*Publicação Selected Item*/
        $(".card-item-privacidade").click(function () {
            /**/
            var _thisTexto = $(this);
            /**/
            var _privacitySelected = _thisTexto.attr('data-pub-value');
            /*Joga um número de 1 a 12 dentro do input para saber qual o tipo de publicação*/
            $('#card-selected').val(_privacitySelected);
            /**/
            $('#card-privacidade').html(_thisTexto.html() + ' <i class="icon-chevron-down"></i>');

            if (_privacitySelected == '3') {
                $('#pb_marcar_alunos').show();
            }
        });
    },
    'tocarAudio': function () {
        isAudioPlayed = false;
        $('.social-audio').click(function () {
            isAudioPlayed = true;
            var _thisId = $(this).attr('data-pubad-id');

            var _srcAudio = $(this).attr('data-src-audio');

            var idDoAudio = "social-audio-" + _thisId;

            var _audio = document.getElementById(idDoAudio);

            if (_audio == null) {

                var audioHTML = '<audio style="height:40px;" autoplay="" controls="" src="' + _srcAudio + '" class="social-audios-views" id="' + idDoAudio + '"></audio>';
                $('#file-audio-' + _thisId).html(audioHTML);
            }

            if (_audio != null) {
                if (_audio.paused == true) {
                    _audio.play();
                    _audio.paused = false;
                } else {
                    _audio.pause();
                    _audio.paused = true;
                }
            }

            if ($('audio').size() > 0) {
                var audios = document.getElementsByTagName('audio');
                for (dx = 0; dx < audios.length; ++dx) {
                    if (audios[dx].id != idDoAudio) {
                        audios[dx].pause();
                    }
                }
            }

        });

    }, /*
     'cardEditorPeplayComment':function(){
     $('.card-editor-replay-comment').click(function() {
     
     var _thisElemtn = $(this);
     
     if (_thisElemtn.text().trim() == 'Escreva um comentário...') {
     _thisElemtn.text('').focus();
     }
     
     }).keyup(function(ev) {
     if (ev.keyCode == 13) {
     console.log('Taffarel');
     }
     }); 
     },*/
    /*
     * Inicia as configurações do App.
     */
    'initApp': function () {
        this.btnReplyComment();
        this.getAlunosMarcados();
        this.btnDropDownExcluirPublicacao();
        this.excluirPublicacao();
        this.btnCommentCard();
        this.btnCompartilharPublicacao();
        this.btnEditarCard();
        this.btnOcultarCard();
        this.abrirModal();
    }

};