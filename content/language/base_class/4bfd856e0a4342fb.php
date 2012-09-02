<h1>TPersistent</h1>
<div class="date">01.01.2007</div>


<p>"Persistent" в переводе с английского означает "устойчивый", "постоянный". Что же такого постоянного в одноименном классе? Ответ таков: виртуальный метод </p>
<p>procedure Assign(Source: TPersistent); </p>
<p>Этот важнейший метод осуществляет копирование содержимого одного объекта (source) в другой (self, т. е. в объект, вызвавший метод Assign). При этом объект-получатель остается самим собой, чего нельзя достигнуть, используя простое присваивание переменных объектного типа: </p>
<p>FirstObject := SecondObject; </p>
<p>Ведь в этом случае указатель на одну область адресного пространства, содержащую экземпляр класса (объект), замещается указателем на другую область адресного пространства, содержащую другой объект. </p>
<p>Метод Assign позволяет продублировать объект &#8212; присвоить одному объекту значения всех свойств другого. При этом объекты не обязательно должны быть одного и того же класса; более того, они не обязательно должны находиться в отношениях "родитель-потомок". Данный метод тем и хорош, что позволяет полиморфное присвоение. Конструкция </p>
<p>Clipboard.Assign(Picture); </p>
<p>позволяет скопировать содержимое картинки Picture в папку обмена Windows (объект clipboard). Какова здесь логика? Известно, что в папку обмена можно поместить растровую картинку, текст, метафайл, мультимедийные данные и т. п. Метод Assign класса TClipboard переписан таким образом, чтобы обеспечить присвоение (т. е. реальное перемещение в папку обмена) всех этих данных. </p>
<pre>
procedure TCiipboard.Assign(Source: TPersistent); 
begin 
  if Source is TPicture then 
    AssignPicture(TPicture(Source))  
  else 
    if Source is TGraphic then 
      AssignGraphic(TGraphic(Source)) 
    else  
      inherited Assign(Source); 
end; 
</pre>
<p>Для обеспечения взаимодействия потомков класса TPersistent со средой разработки предназначен метод </p>
<p>function GetNamePath: string; dynamic; </p>
<p>Он возвращает имя объекта для передачи его в Инспектор объектов. </p>
<p>Для взаимодействия с потоками при загрузке и сохранении компонентов предназначен следующий метод: </p>
<p>procedure DefineProperties(Filer: TFiler); virtual; </p>
<p>Класс TPersistent никогда не используется напрямую, от него порождаются потомки, которые должны уметь передавать другим объектам значения своих свойств, но не являться при этом компонентами. </p>

