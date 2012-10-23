<h1>Введение в Rave</h1>
<div class="date">01.01.2007</div>


<p>Панель компонент Rave</p>
<p>Имеются два типа объектов в Rave, компоненты вывода (Output Components) и классы отчета (Report Classes). Компоненты вывода отвечают за вывод отчета на различные устройства вывода, а классы отчета, которые не являются компонентными классами, отвечают за все остальные задачи.</p>
<p><img src="/pic/embim1741.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvSystem &nbsp; &nbsp; &nbsp; &nbsp;Включает в себя стандартный принтер и предварительный просмотр и является одним из самых простых в использовании компонент. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1742.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TRvNDRWriter &nbsp; &nbsp; &nbsp; &nbsp;Создает NDR поток или файл (в должном формате) при выполнении отчета. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1743.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvRenderPreview &nbsp; &nbsp; &nbsp; &nbsp;Показывает диалог предварительного просмотра для NDR потока или файла. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1744.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvRenderPrinter &nbsp; &nbsp; &nbsp; &nbsp;Посылает NDR поток или файл на принтер. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1745.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TRvRenderPDF &nbsp; &nbsp; &nbsp; &nbsp;Преобразовывает NDR поток или файл в PDF формат. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1746.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TRvRenderHTML &nbsp; &nbsp; &nbsp; &nbsp;Преобразовывает NDR поток или файл в HTML формат. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1747.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TRvRenderRTF &nbsp; &nbsp; &nbsp; &nbsp;Преобразовывает NDR поток или файл в RTF формат. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1748.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TRvRenderText &nbsp; &nbsp; &nbsp; &nbsp;Преобразовывает NDR поток или файл в Text формат. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Классы Rave</p>
<p><img src="/pic/embim1749.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvProject &nbsp; &nbsp; &nbsp; &nbsp;Производит соединение к проекту отчета, который был создан с помощью визуального редактора Rave. Используйте данный компонент для получения списка всех доступных отчетов или для выполнения конкретного отчета. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1750.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvCustomConnection &nbsp; &nbsp; &nbsp; &nbsp;Подсоединяет пользовательские данные (сгенерированные через события) к DirectDataViews, созданные с помощью визуального редактора Rave. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1751.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvDataSetConnection &nbsp; &nbsp; &nbsp; &nbsp;Подсоединяет TDataSet данные (например, TClientDataSet, или компоненты третьих сторон, наследники&nbsp; от TDataSet) к DirectDataViews, созданные с помощью визуального редактора Rave. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1752.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvTableConnection &nbsp; &nbsp; &nbsp; &nbsp;Подсоединяет TTable компоненты к DirectDataViews, созданные с помощью визуального редактора Rave. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p><img src="/pic/embim1753.png" width="56" height="55" vspace="1" hspace="1" border="0" alt=""> &nbsp; &nbsp; &nbsp; &nbsp;TrvQueryConnection &nbsp; &nbsp; &nbsp; &nbsp;Подсоединяет TQuery компоненты к DirectDataViews, созданные с помощью визуального редактора Rave. &nbsp; &nbsp; &nbsp; &nbsp;</p>

