<h1>Основное отличие exe-файлов созданных Delphi и Visual Basic</h1>
<div class="date">01.01.2007</div>


<p>Основное отличие EXE-файлов созданных Delphi и Visual Basic </p>

<p>Существует два важных различия между файлами EXE, созданными в Delphi, и файлами EXE, созданными VB. Delphi создает чисто машинный код, непосредственно исполняемый компьютером, в то время как VB транслирует исходный код в промежуточную форму (р-код). Файл EXE, сгенерированный VB, в действительности является программой-интерпретатором р-кода с добавленным в конце р-кодом программы пользователя.</p>

<p>"Библиотека времени выполнения" (run-time library) стандартных функций для всех программ VB хранится в файле VBRUN300.DLL. Каждая программа VB, попавшая к конечному пользователю, должна включать этот файл, либо приходится расчитывать, что такой файл у пользователя уже есть. Дистрибутивный комплект программы должен также содержать файлы VBX для каждого управляющего средства VB, не включенного в VBRUN300.DLL.</p>

<p>Программы Delphi включают необходимую часть библиотеки времени выполнения Delphi, а также используемые компоненты. В результате EXE-файл Delphi обычно больше по объему, чем эквивалентный EXE-файл VB, но он не зависит ни от каких внешних файлов.</p>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>

