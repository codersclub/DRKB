<h1>Как поместить картинку из базы данных, например MsSQL, в компонент TImage?</h1>
<div class="date">01.01.2007</div>


<p>Предполагается, что поле BLOB (например, Pict)</p>
<p>2) в запросе Query.SQL пишется что-то вроде</p>
<p>'select Pict from sometable where somefield=somevalue'</p>
<p>3) запрос открывается</p>
<p>4) делается "присваивание":</p>
<p>Image1.Picture.Assing(TBlobField(Query.FieldByName('Pict'))</p>
<p>или, если известно, что эта картинка - Bitmap, то можно</p>
<p>Image1.Picture.Bitmap.Assing(TBlobField(Query.FieldByName('Pict'))</p>

<p>А можно воспользоваться компонентом TDBImage.</p>

<p>Зайцев О.В.</p>
<p>Владимиров А.М.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

