function changeStatus(id) {
    showStatics(id);

}

function showStatics(dataAjax = null, detailChart = null) {
    let cData =$("#data").val();
    let nameData =$("#name-data").val();
    let data =JSON.parse(cData);
    let dataKey = 1;
    let showTooltip = true;
    let keyLegend = true;
    if(dataAjax != null) {
        dataKey = dataAjax;
    }

    if(data.length > 0) {
        $('#chartPlace').removeClass("d-none");

    } else {
        $('#chartPlace').addClass("d-none");
    }

    let itemName = ['総収容人数', '現在の収容人数'];
    let categories = [];
    let dataMale = ['男'];
    let dataFeMale = ['女'];
    let dataChart = ['現在の収容人数'];
    let dataChartCurrent = ['総収容人数'];
    let dataPercentPlace = ['収容率']
    let dataPregnantWoman = ['妊産婦'];
    let dataInfant = ['新生児'];
    let dataPersonsWithDisabilities = ['乳幼児'];
    let dataNursingCareRecipient = ['要介護者'];
    let dataMedicalDeviceUsers = ['障碍者'];
    let dataAllergies = ['医療機器利用者'];
    let dataForeignNationality = ['外国籍'];
    let dataNewbornBaby = ['アレルギー'];
    let dataOther = ['その他'];

    let dataImport = [dataChart, dataChartCurrent]

    let table = $('#chartPlace');
    table.height(data.length * 85);
    // table.width(data.length * 200);
    // if(detailChart) {
    //     table.height(data.length * 500);
    //     table.width(data.length * 800);
    // }
    $.each(data, function(i, item) {
        if(item.name.length > 15) {
            categories.push(item.name.slice(0, 15)+"...");
        } else {
            categories.push(item.name);
        }

        if(dataKey == 1) {
            dataImport = [dataMale, dataFeMale]
            dataMale.push(item.countMale);
            dataFeMale.push((item.totalPerson - item.countMale));
            itemName = ['男', '女']
            keyLegend = true
            showTooltip = true
        }

        if(dataKey == 2) {
            keyLegend = false
            dataImport = [dataPercentPlace]
            itemName = ['男']
            percentPerson = (100 - (((item.total_place - item.totalPerson) / item.total_place) * 100)).toFixed(2);
            dataPercentPlace.push(percentPerson).toFixed(2);
        }

        if(dataKey == 3) {
            dataImport = [dataPregnantWoman, dataInfant, dataPersonsWithDisabilities, dataNursingCareRecipient, dataMedicalDeviceUsers, dataAllergies, dataForeignNationality, dataNewbornBaby, dataOther]
            itemName = ['妊産婦', '新生児', '乳幼児', '要介護者', '障碍者', '医療機器利用者', '外国籍', 'アレルギー', 'その他']
            dataPregnantWoman.push(item.countPregnantWoman);
            dataInfant.push(item.countInfant);
            dataPersonsWithDisabilities.push(item.countPersonsWithDisabilities);
            dataNursingCareRecipient.push(item.countNursingCareRecipient);
            dataMedicalDeviceUsers.push(item.countMedicalDeviceUsers);
            dataAllergies.push(item.countAllergies);
            dataForeignNationality.push(item.countForeignNationality);
            dataNewbornBaby.push(item.countNewbornBaby);
            dataOther.push(item.countOther);
        }

    });


    function tooltip_contents(d, defaultTitleFormat, defaultValueFormat, color) {
        let titleTooltip = '人';
        if(dataKey == 2) {
            titleTooltip = '%';
        }

        var $$ = this, config = $$.config, CLASS = $$.CLASS,
            titleFormat = config.tooltip_format_title || defaultTitleFormat,
            nameFormat = config.tooltip_format_name || function (name) { return name; },
            text, i, title, value, name, bgcolor;

        for (i = 0; i < d.length; i++) {
            if (! text) {
                title = titleFormat ? titleFormat(d[i].x) : d[i].x;
                if(dataKey == 2) {
                    text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "" : "");
                } else {
                    text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "<tr><th colspan='2'>" + title + "</th></tr>" : "");
                }
            }

            name = nameFormat(d[i].name);
            bgcolor = $$.levelColor ? $$.levelColor(d[i].value) : color(d[i].id);

            if(dataKey == 2) {
                text += "<td class='value'>" + d[i].value + titleTooltip + "</td>";

            } else {
                text += "<tr class='" + CLASS.tooltipName + "-" + d[i].id + "'>";
                text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>" + name + "</td>";
                text += "<td class='value'>" + d[i].value + titleTooltip + "</td>";
                text += "</tr>";
            }

        }
        return text + "</table>";
    }

    let chart = c3.generate({
        bindto: '#chartPlace',
        data: {
            columns: dataImport,

            groups: [
                itemName
            ],
            type:  'bar',
        },
        axis: {
            rotated: true,
            x: {
                show: true,
                type: 'category',
                categories: categories,
            },

            y: {
                tick: {
                    format: function (d) {
                        if(dataKey == 2) {
                            return d + '%';
                        }
                        return d;
                    },
                },
            },
        },

        legend: {
            show : keyLegend
        },

        tooltip: {
            show: showTooltip,
            contents: tooltip_contents
        },

    });

}
showStatics();





