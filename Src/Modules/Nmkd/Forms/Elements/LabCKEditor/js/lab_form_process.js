document.getElementById("lab_form").addEventListener("submit", function(event){
    labFormProcess(event);
});

function labFormProcess(event) {
    var i;
    var doc = CKEDITOR.instances["lab_form-element-14"].document;
    var fields = [
        "theme",
        "type",
        "purpose",
        "theory",
        "execution_order",
        "content_structure",
        "requirements",
        "individual_variants",
        "literature"
    ];
    var fieldTitles = [
        "Тема",
        "Вид заняття",
        "Мета",
        "Теоретичний матеріал",
        "Порядок виконання",
        "Структура змісту текстових розділів звітних матеріалів",
        "Вимоги до оформлення роботи та опис процедури її захисту",
        "Варіанти індивідуальних завдань",
        "Рекомендована література"
    ];
    var emptySections = '';

    for (i = 0; i < fields.length; i++) {
        if (doc.getById("lab-"+fields[i]+"-body") === null) {
            emptySections += '\r\n - '+fieldTitles[i];
            continue;
        }
        document.getElementsByName(fields[i])[0].value = doc.getById("lab-"+fields[i]+"-body").getHtml();
    }
    if (emptySections !== '') {
        if (!confirm('Ви не визначили наступні частини:'+emptySections+'\r\n\r\nПродовжити відправку?')) {
            event.preventDefault();
        }
    }
}