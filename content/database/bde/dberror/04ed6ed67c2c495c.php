<h1>При использовании BDE, попытка вызвать abort выдает ошибку компиляции</h1>
<div class="date">01.01.2007</div>


<p>При использовании модулей доступа к BDE (DbiTypes, DbiProcs, DbiErrs), любая попытка вызвать процедуру abort выдает ошибку при компиляции при вызове метода abort "Statement expected, but expression of type 'Integer' found". Я пытался найти DbiTypes.pas, DbiProcs.pas и DbiErrs.pas чтобы разобраться но не нашел этих файлов. Где расположены эти файлы и как обойти ошибку?</p>

<p>Модули DbiTypes, DbiProcs, DbiErrs это псевдонимы модуля "BDE", обьявлены в Projects-&gt;Options-&gt;Directories/Conditionals-&gt;Unit Aliases. Исходник модуля DBE находится в каталоге "doc" и называется "BDE.INT". В этом файле обьявленна константа ABORT со значением -2. Так как Вы хотите использовать процедуру Abort(), которая обьявлена в модуле SysUtils, Вам нужно добавить префикс SysUtils перед вызовом процедуры Abort.</p>

<p>SysUtils.Abort;</p>

