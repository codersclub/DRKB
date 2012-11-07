<h1>Как привязать файлы помощи в Delphi</h1>
<div class="date">01.01.2007</div>


<p>Вот как это делаю я:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">1.</td><td>Сначала создайте файл помощи. Откройте меню "Project/Options...", щелкните на закладке "Application" и введите путь к файлу помощи в строке "Help File". Или же вы можете сделать это непосредственно во время выполнения приложения, указав соответственное значение свойству Application.HelpFile.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">2.</td><td>Затем вам необходимо присвоить значения свойству "HelpContext" у необходимых элементов управления. В нашем случае необходимо задать значение свойству "HelpContext" у кнопки "Help", обычно расположенной на вспомогательных окнах или диалогах.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">3.</td><td>Наконец, в обработчике события нажатия на кнопку вызовите метод Application.HelpContext. Для нашей кнопки "Help" обработчик события OnClick мог бы выглядеть примерно так:</td></tr></table></div>
<p>procedure TForm1.btnHelpClick(Sender: TObject);</p>
<p>begin</p>
<p>  Application.HelpContext(TButton(Sender).HelpContext);</p>
<p>end;</p>
<p>Это все!</p>
<p>Вы также можете вызывать другие методы Application для вывода файлов помощи, такие, как Application.HelpCommand и Application.HelpJump.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
