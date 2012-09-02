<h1>Динамические и виртуальные методы</h1>
<div class="date">01.01.2007</div>


<p>Согласно онлайновой документации, динамические и виртуальные методы семантически идентичны, единственно различие заключается в их реализации, нижеследующий код генерирует указанную ошибку компиляции:</p>

<pre>
type t = class
    function a: integer; {статический}
    function b: integer; virtual;
    function c: integer; dynamic;
    property i: integer read a; { ok }
    property j: integer read b; { ok }
    property k: integer read c;{ ОШИБКА: type mismatch (не совпадение типа) }
  end;
</pre>


<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

