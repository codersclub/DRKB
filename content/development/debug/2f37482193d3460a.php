<h1>Масштабирование окон приложений, в зависимости от разрешения экрана</h1>
<div class="date">01.01.2007</div>


<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">1.</td><td>В ранней стадии создания приложения решите для себя хотите ли вы позволить форме масштабироваться. Преимущество немасштабируемой формы в том, что ничего не меняется во время выполнения. В этом же заключается и недостаток (ваша форма может бать слишком маленькой или слишком большой в некоторых случаях).</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">2.</td><td>Если вы не собираетесь делать форму масштабируемой, установите св-во Scaled=False и дальше не читайте. В противном случае Scaled=True.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">3.</td><td>Установите AutoScroll=False. AutoScroll = True означает не менять размер окна формы при выполнении что не очень хорошо выглядит, когда содержимое формы размер меняет.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">4.</td><td>Установите фонты в форме на TrueType фонты, например Arial. Если такого фонта не окажется на пользовательском компьютере, то Windows выберет альтернативный фонт из того же семейства. Этот фонт может не совпадать по размеру, что вызовет проблемы.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">5.</td><td>Установите св-во Position в любое значение, отличное от poDesigned. poDesigned оставляет форму там, где она была во время дизайна, и, например, при разрешении 1280x1024 форма окажется в левом верхнем углу и совершенно за экраном при 640x480.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">6.</td><td>Оставляйте по-крайней мере 4 точки между компонентами, чтобы при смене положения границы на одну позицию компоненты не "наезжали" друг на друга. Для однострочных меток (TLabel) с выравниванием alLeft или alRight установите AutoSize=True. Иначе AutoSize=False.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">7.</td><td>Убедитесь, что достаточно пустого места у TLabel для изменения ширины фонта - 25\% пустого места многовато, зато безопасно. При AutoSize=False Убедитесь, что ширина метки правильная, при AutoSize=True убедитесь, что есть ссвободное место для роста метки.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">8.</td><td>Для многострочных меток (word-wrapped labels), оставьте хотя бы одну пустую строку снизу.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">9.</td><td>Будьте осторожны при открытии проекта в среде Delphi при разных разрешениях. Свойство PixelsPerInch меняется при открытии формы. Лучше тестировать приложения при разных разрешениях, запуская готовый скомпилированный проект, а редактировать его при одном разрешении. Иначе это вызовет проблемы с размерами.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">10.</td><td>Не изменяйте свойство PixelsPerInch !</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">11.</td><td>В общем, нет необходимости тестировать приложение для каждого разрешения в отдельности, но стоит проверить его на 640x480 с маленькими и большими фонтами и на более высоком разрешении перед продажей.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">12.</td><td>Уделите пристальное внимание принципиально однострочным компонентам типа TDBLookupCombo. Многострочные компоненты всегда показывают только целые строки, а TEdit покажет урезанную снизу строку. Каждый компонент лучше сделать на несколько точек больше.</td></tr></table>
<div class="author">Автор: Song</div>
