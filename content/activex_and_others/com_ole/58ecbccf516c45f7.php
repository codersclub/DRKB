<h1>Интерфейс OLE AutoServer</h1>
<div class="date">01.01.2007</div>


<p>Это не улыбка, а дружественный интерфейс.&nbsp; </p>
<p>Я пытаюсь создать in-process oleserver с возможностью обратного вызова (callback). Я хочу передавать мой ole-объект MS C++ dll так, чтобы DLL могла бы вызываться из сервера. Проблема в том, что dll "вылетает", если мой сервер - Delphi 2.0, но работает в VB 4.0 </p>
<p>Проблема в том, что вы передаете со стороны Delphi Variant, но на стороне C++ "ожидают" IUnknown. Измените прототип функции Delphi следующим образом:</p>
<p>function SmtOleLink(OleCallBack: IUnknown; ...) ...;</p>
<p>Для получения доступа к типу IUnknown необходимо добавить "Ole2" к списку используемых модулей. Теперь измените вызов со стороны Delphi:</p>
<div class="author">Автор: Anders Hejlsberg</div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
