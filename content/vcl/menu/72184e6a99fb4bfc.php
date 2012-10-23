<h1>Как сделать меню как в Delphi?</h1>
<div class="date">01.01.2007</div>



<p>1. Разместите на форме TControlBar. (закладка Additional) Установите Align = Client.</p>
<p>2. Разместите TToolBar (закладка Win32) внутри TControlBar.</p>
<p>3. Установите в True свойства Flat и ShowCaptions этого TToolBar.</p>
<p>4. Создайте на TToolBar столько TToolButtons сколько Вам нужно. (щелкнув по TToolBar</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;правой кнопкой и выбрав NewButton)</p>
<p>5. Установите свойство Grouped = True для всех TToolButtons. Это позволит меню выпадать</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;при перемещении курсора между главными пунктами меню (если меню уже показано).</p>
<p>6. Разместите на фоме TMainMenu и убедитесь, что оно *НЕ присоденено* как меню главной</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;формы. (посмотрите свойство Menu формы).</p>
<p>7. Создайте все пункты меню (щелкнув по TMainMenu кнопкой и выбрав Menu Designer)</p>
<p>8. Для каждой TToolButton установите ее MenuItem равным соответсвующему пункту TMainMenu.</p>
<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>

