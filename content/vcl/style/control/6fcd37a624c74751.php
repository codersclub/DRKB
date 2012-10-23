<h1>Компоненты настройки цветовой палитры</h1>
<div class="date">01.01.2007</div>


<p>Помимо создания собственных визуальных стилей, что является делом довольно трудоемким и хлопотным, вы можете изменить внешний вид пользовательского интерфейса приложения более легким способом. Впервые в составе Палитры компонентов Delphi 7 появились специализированные компоненты, позволяющие настраивать цветовую палитру всех возможных деталей пользовательского интерфейса одновременно. Эти компоненты расположены на странице Additional:</p>
<p> TstandardColorMap &#8212; по умолчанию настроен на стандартную цветовую палитру Windows;</p>
<p> TXPColorMap &#8212; по умолчанию настроен на стандартную цветовую палитру Windows XP;</p>
<p> TTwilightColorMap &#8212; по умолчанию настроен на стандартную полутоновую (черно-белую) палитру Windows.</p>
<p>Все они представляют собой контейнер, содержащий цвета для раскраски различных деталей элементов управления. Разработчику необходимо лишь настроить эту цветовую палитру и по мере необходимости подключать к пользовательскому интерфейсу приложения. Для этого снова используется компонент TActionManager.</p>
<p>Все панели инструментов (класс TActionToolBar), созданные в этом компоненте (см. гл. 8), имеют свойство</p>
<pre>
property ColorMap: TCustomActionBarColorMap; 
</pre>
<p>в котором и задается необходимый компонент цветовой палитры. Сразу после подключения все элементы управления на такой панели инструментов перерисовываются в соответствии с цветами новой палитры.</p>
<p>Обратите внимание, что в компоненте TToolBar, перенесенном из Палитры компонентов на форму вручную, это свойство отсутствует.</p>
<p>Все компоненты настройки цветовой палитры имеют один метод-обработчик</p>
<pre>
property OnColorChange: TnotifyEvent; 
</pre>
<p>который вызывается при изменении любого цвета палитры.</p>

