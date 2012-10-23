<h1>Функции и процедуры для работы с курсором</h1>
<div class="date">01.01.2007</div>


<p>Функция CursorToIdent (Cursor: Longint;var Ident: string): Boolean;</p>
<p>Функция возвращает строковое значение предопределенной константы, определяющее вид курсора. Числовое значение, определяющее вид курсора, передается в параметре Cursor. Строковое значение константы возвращается в параметре Ident. Если для указанного числового значения, определяющего вид курсора, есть соответствующая строковая константа, то функция возвращает True, а иначе - False.</p>
<p>На практике возникают ситуации, когда необходимо, чтобы функция возвращала в результате строковое значение даже в том случае, когда для числового значения вида курсора, нет предопределенной строковой константы. В данных ситуациях используйте функцию CursorToString</p>
<p>Функция CursorToString( Cursor: TCursor ): string;</p>
<p>type TCursor = -32768...32767;</p>
<p>Функция возвращает строковое значение константы или числа, соответствующих указанному виду курсора. Числовое значение, определяющее вид курсора, передается в параметре Cursor. Если указанному значению соответствует предопределенная строковая константа, то функция возвращает имя этой константы, иначе возвращается строковое представление значения переданного в параметре Cursor.</p>
<p>Процедура GetCursorValues( Proc: TGetStrProc );</p>
<p>type TGetStrProc = Procedure( const S: string ) of Object;</p>
<p>Процедура передает каждое предопределенное в VCL имя курсора (значение предопределенной строковой константы, определяющей вид курсора) процедуре повторного вызова Proc.</p>
<p>Функция IdentToCursor (const Ident: string;var Cursor: Longint ): Boolean;</p>
<p>Функция возвращает числовое значение, соответствующее строковой константе, определяющей вид курсора. Строковое значение передается в параметре Ident. Числовое значение возвращается в переменной Cursor. При успешном выполнении функция возвращает True, а если значение Ident не является предопределенной константой, то функция возвращает False.Данная функция обратна по функциональности функции CursorToIdent.</p>
<p>Функция StringToCursor( const S: string ): TCursor;</p>
<p>type TCursor = -32768...32767;</p>
<p>Функция преобразовывает строковое значение S, определяющее вид курсора, в значение типа TCursor. Функция обратна по функциональности функции CursorToString. Параметр S должен представлять собой либо предопределенную константу вида курсора, либо строковое представление соответствующего ему числового значения, в противном случае возникнет исключение EConvertError.</p>
<pre>
var
  I1,I2: Longint;
begin
  I1:= StringToCursor('crHelp'); // I1:= -20
  I2:= StringToCursor('-20'); // I2:= -20
end;
</pre>

<p>Взято с <a href="https://atrussk.ru/delphi/" target="_blank">https://atrussk.ru/delphi/</a></p>
