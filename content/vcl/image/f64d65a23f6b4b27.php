<h1>TImageList &ndash; не отображаются иконки на контролах</h1>
<div class="date">01.01.2007</div>

Не отображаются картинки на тулбарах, кнопках, меню, и т.д. - везде, где используется TImageList для хранения массива изображений. Искажение цветов при использовании 256-цветных картинок в палитровом видеорежиме.</p>
<p>ТИПОВЫЕ РЕШЕНИЯ.</p>
<p>Не использовать TImageList, если это возможно.</p>
<p>Не хранить содержимое TImageList в ресурсе формы, а загружать в runtime из подготовленной bitmap или ресурса.</p>
<p>Обновить версию системной библиотеки comctl32.dll.</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
