<h1>Введение в Rave</h1>
<div class="date">01.01.2007</div>


<p>Панель компонент Rave</p>
<p>Имеются два типа объектов в Rave, компоненты вывода (Output Components) и классы отчета (Report Classes). Компоненты вывода отвечают за вывод отчета на различные устройства вывода, а классы отчета, которые не являются компонентными классами, отвечают за все остальные задачи.</p>
<p><img src="/pic/embim1741.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvSystem        Включает в себя стандартный принтер и предварительный просмотр и является одним из самых простых в использовании компонент.</p>
<p><img src="/pic/embim1742.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TRvNDRWriter        Создает NDR поток или файл (в должном формате) при выполнении отчета.</p>
<p><img src="/pic/embim1743.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvRenderPreview        Показывает диалог предварительного просмотра для NDR потока или файла.</p>
<p><img src="/pic/embim1744.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvRenderPrinter        Посылает NDR поток или файл на принтер.</p>
<p><img src="/pic/embim1745.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TRvRenderPDF        Преобразовывает NDR поток или файл в PDF формат.</p>
<p><img src="/pic/embim1746.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TRvRenderHTML        Преобразовывает NDR поток или файл в HTML формат.</p>
<p><img src="/pic/embim1747.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TRvRenderRTF        Преобразовывает NDR поток или файл в RTF формат.</p>
<p><img src="/pic/embim1748.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TRvRenderText        Преобразовывает NDR поток или файл в Text формат.</p>
<p>Классы Rave</p>
<p><img src="/pic/embim1749.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvProject        Производит соединение к проекту отчета, который был создан с помощью визуального редактора Rave. Используйте данный компонент для получения списка всех доступных отчетов или для выполнения конкретного отчета.</p>
<p><img src="/pic/embim1750.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvCustomConnection        Подсоединяет пользовательские данные (сгенерированные через события) к DirectDataViews, созданные с помощью визуального редактора Rave.</p>
<p><img src="/pic/embim1751.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvDataSetConnection        Подсоединяет TDataSet данные (например, TClientDataSet, или компоненты третьих сторон, наследники  от TDataSet) к DirectDataViews, созданные с помощью визуального редактора Rave.</p>
<p><img src="/pic/embim1752.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvTableConnection        Подсоединяет TTable компоненты к DirectDataViews, созданные с помощью визуального редактора Rave.</p>
<p><img src="/pic/embim1753.png" width="56" height="55" vspace="1" hspace="1" border="0" alt="">        TrvQueryConnection        Подсоединяет TQuery компоненты к DirectDataViews, созданные с помощью визуального редактора Rave.</p>

