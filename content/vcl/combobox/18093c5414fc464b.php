<h1>TComboBox.ReadOnly</h1>
<div class="date">01.01.2007</div>


<p>Иногда хочется сделать так, чтобы в комбобоксе, пользователь мог только выбирать из списка но не вводить текст с клавиатуры.</p>
<p>Так можно включить "ComboBox.ReadOnly"</p>
<p>SendMessage(GetWindow(ComboBox1.Handle,GW_CHILD), EM_SETREADONLY, 1, 0);</p>
<p>а так выключить.</p>
<p>SendMessage(GetWindow(ComboBox1.Handle,GW_CHILD), EM_SETREADONLY, 0, 0); </p>
<p>При csDropDownList нельзя набирать для выбора, то есть если нажал "К" а потом "О", то вначале выберется слово на "К" а потом на "О", а так выберется слово на "КО", и текст нельзя из него копировать. </p>
<p class="author">Автор: Fantasist</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

