<h1>Симфония на клавиатуре (статья)</h1>
<div class="date">01.01.2007</div>


<p>Перевод одноимённой статьи с сайта delphi.about.com )</p>
<p>Начиная с самого рассвета компьютерной промышленности, клавиатура была первичным устройством ввода информации, и вероятнее всего сохранит свою позицию ещё долгое время.</p>
<p>События клавиатуры, наряду с событиями мыши, являются основными элементами взаимодействия пользователя с программой. В данной статье пойдёт речь о трёх событиях, которые позволяют отлавливать нажатия клавиш в приложении Delphi: OnKeyDown, OnKeyUp и OnKeyPress.</p>
<p>Для получения ввода с клавиатуры, приложения Delphi могут использовать два метода. Самый простой способ, это воспользоваться одним из компонентов, автоматически реагирущем на нажатия клавиш, таким как Edit. Второй способ заключается в создании процедур в форме, которые будут обрабатывать нажатия и отпускания клавиш. Эти обработчики могут обрабатывать как нажатия одиночных клавиш, так и комбинаций. Итак, вот эти события:</p>
<p>OnKeyDown - вызывается, когда на клавиатуре нажимается любая клавиша. OnKeyUp - вызывается, когда любая клавиша на клавиатуре отпускается. OnKeyPress - вызывается, когда нажимается клавиша, отвечающая за определённый ASCII символ.</p>
<p>Теперь самое время посмотреть, как выглядят в программе заголовки обработчиков:</p>
<pre>
procedure TForm1.FormKeyDown
(Sender: TObject; var Key: Word; Shift: TShiftState);
...
procedure TForm1.FormKeyUp
(Sender: TObject; var Key: Word; Shift: TShiftState);
...
procedure TForm1.FormKeyPress
(Sender: TObject; var Key: Char);
</pre>

<p>Все события имеют один общий параметр, обычно называемый Key. Этот параметр используется для передачи кода нажатой клавиши. Параметр Shift (в процедурах OnKeyDown и OnKeyUp), указывает на то, была ли нажата клавиша в сочетании с Shift, Alt, и Ctrl.</p>

<p>Фокус</p>
<p>Фокус, это способность получать пользовательский ввод через мышь или клавиатуру. Получать события от клавиатуры могут только те объекты, которые имеют фокус. На форме активного приложения в один момент времени может быть активным (иметь фокус) только один компонент.</p>
<p>Некоторые компоненты, такие как TImage, TPaintBox, TPanel и TLabel не могут получать фокус, другими словами, это компоненты, наследованные от TGraphicControl. Так же не могут получать фокус невидимые компоненты, такие как TTimer.</p>
<p>OnKeyDown, OnKeyUp</p>
<p>События OnKeyDown и OnKeyUp обеспечивают самый низкий уровень ответа клавиатуры. Обработчики OnKeyDown и OnKeyUp могут реагировать на все клавиши клавиатуры, включая функциональные и комбинации с клавишами Shift, Alt, и Ctrl.</p>
<p>События клавиатуры - не взаимоисключающие. Когда пользователь нажимает клавишу, то генерируются два события OnKeyDown и OnKeyPress, а когда отпускает, то только одно: OnKeyUp. Если пользователь нажмёт одну из клавиш, которую OnKeyPress не сможет определить, то будет сгенерировано только одно событие OnKeyDown, а при отпускании OnKeyUp.</p>
<p>OnKeyPress</p>
<p>OnKeyPress возвращает различные значения ASCII для 'g' и 'G,'. Однако, OnKeyDown и OnKeyUp не делают различия между верхним и нижним регистром.</p>
<p>Параметры Key и Shift</p>
<p>Параметр Key можно изменять, чтобы приложение получило другой код нажатой клавиши. Таким образом можно ограничивать набор различных символов, которые пользователь может ввести с клавиатуры. Например разрешить вводить только цифры. Для этого добавьте в обработчик события OnKeyPress следующий код и установите KeyPreview в True (см. ниже).</p>
<pre>
if Key in ['a'..'z'] + ['A'..'Z'] then Key:=#0
</pre>

<p>Это выражение проверяет, содержит ли параметр Key символы нижнего регистра ('a'..'z') и символы верхнего регистра ('A'..'Z'). Если так, то в параметр заносится значение нуля, чтобы предотвратить ввод в компонент Edit (например).</p>
<p>В Windows определены специальные константы для каждой клавиши. Например, VK_RIGHT соответствует коду клавиши для правой стрелки.</p>
<p>Чтобы получить состояния специальных клавиш, таких как TAB или PageUp можно воспользоваться API функцией GetKeyState. Клавиши состояния могут находиться в трёх состояниях: отпущена, нажата, и включена. Если старший бит равен 1, то клавиша нажата, иначе отпущена. Для проверки этого бита можно воспользоваться API функцией HiWord. Если младший бит равен 1, то клавиша включена. Вот пример получения сосотояния специальной клавиши:</p>
<pre>
if HiWord(GetKeyState(vk_PageUp)) &lt;&gt; 0 then
  ShowMessage('PageUp - DOWN')
else
  ShowMessage('PageUp - UP');
</pre>

<p>В событиях OnKeyDown и OnKeyUp, Key является беззнаковым двухбайтовым (Word) значением, которое представляет виртуальную клавишу Windows. Для получания значения символа можно воспользоваться функцией Chr. В событии OnKeyPress параметр Key является значением Char, которое представляет символ ASCII.</p>
<p>События OnKeyDown и OnKeyUp имеют параметр Shift с типом TShiftState. В Delphi тип TShiftState определён как набор флагов, определяющих состояние Alt, Ctrl, и Shift при нажатии клавиши.</p>
<p>Например, следующий код (из обработчика OnKeyUp) соединяет строку 'Ctrl +' с нажатой клавишей и отображает результат в заголовке формы:</p>
<pre>
if ssCtrl in Shift then
  Form1.Caption:= 'Ctrl +' + Chr(Key);
</pre>

<p>Если нажать Ctrl + A, то будут сгенерированы следующие события:</p>

<p>KeyDown (Ctrl) // ssCtrl</p>
<p>KeyDown (Ctrl+A) //ssCtrl + 'A'</p>
<p>KeyPress (A)</p>
<p>KeyUp (Ctrl+A)</p>

<p>Переадресация событий клавиатуры в форму</p>
<p>Клавиатурный обработчик может работать на двух уровнях: на уровне компонентов и на уровне формы. Свойство формы KeyPreview определяет, будут ли клавиатурные события формы вызываться перед клавиатурными событиями компонентов, так как форма может получать все нажатия клавиш, предназначенные для компонента имеющего в данный момент фокус.</p>
<p>Чтобы перехватить нажатия клавиш на уровне формы, до того как они будут переданы компонентам на форме, необходимо установить свойство KeyPreview в True. После этого компонент как и раньше будет получать события, однако сперва они будут попадать в форму, чтобы дать возможность программе разрешить или запретить ввод различных символов.</p>
<p>Допустим, У Вас на форме есть несколько компонентов Edit и процедура Form.OnKeyPress выглядит следующим образом:</p>
<pre>
procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
begin
 if Key in ['0'..'9'] then Key := #0
end;
</pre>

<p>Если один из компонентов Edit имеет фокус и свойство KeyPreview установлено в False, то этот код не будет выполнен - другими словами, если пользователь нажмёт клавишу '5', то в компоненте Edit, имеющем фокус, появится символ "5".</p>
<p>Однако, если KeyPreview установлено в True, то событие формы OnKeyPress будет выполнено до того, как компонент Edit увидит нажатую клавишу. Поэтому, если пользователь нажмёт клавишу '5', то в Key будет подставлено нулевое значение, предотвращая тем самым попадание числовых символов в Edit.</p>

<p>ПРИЛОЖЕНИЕ: Таблица кодов виртуальных клавиш.</p>

    <table border="1" cellPadding="1" cellSpacing="1">
<TBODY>
      <tr>
        <th align="left" width="34%"><font color="#808080" face="verdana, geneva, helvetica"
        size="1">Symbolic <br>
        constant name</font></th>
        <th align="left" width="23%"><font color="#808080" face="verdana, geneva, helvetica"
        size="1">Value<br>
        (hexadecimal)</font></th>
        <th align="left" width="43%"><font color="#808080" face="verdana, geneva, helvetica"
        size="1">Keyboard (or mouse) equivalent</font></th>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_LBUTTON</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">01</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Left mouse button </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_RBUTTON</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">02</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Right mouse button </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_CANCEL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">03</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Control-break processing </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_MBUTTON</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">04</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Middle mouse button
        (three-button mouse) </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_BACK</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">08</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">BACKSPACE key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_TAB</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">09</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">TAB key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_CLEAR</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">0C</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">CLEAR key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_RETURN</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">0D</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">ENTER key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SHIFT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">10</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">SHIFT key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_CONTROL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">11</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">CTRL key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_MENU</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">12</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">ALT key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_PAUSE</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">13</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">PAUSE key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_CAPITAL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">14</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">CAPS LOCK key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_ESCAPE</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">1B</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">ESC key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SPACE</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">20</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">SPACEBAR </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_PRIOR</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">21</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">PAGE UP key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NEXT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">22</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">PAGE DOWN key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_END</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">23</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">END key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_HOME</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">24</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">HOME key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_LEFT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">25</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">LEFT ARROW key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_UP</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">26</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">UP ARROW key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_RIGHT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">27</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">RIGHT ARROW key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_DOWN</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">28</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">DOWN ARROW key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SELECT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">29</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">SELECT key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_PRINT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">2A</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">PRINT key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_EXECUTE</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">2B</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">EXECUTE key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SNAPSHOT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">2C</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">PRINT SCREEN key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_INSERT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">2D</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">INS key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_DELETE</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">2E</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">DEL key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_HELP</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">2F</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">HELP key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">30</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">0 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">31</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">1 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">32</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">2 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">33</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">3 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">34</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">4 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">35</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">5 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">36</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">6 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">37</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">7 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">38</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">8 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">39</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">9 key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">41</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">A key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">42</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">B key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">43</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">C key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">44</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">D key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">45</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">E key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">46</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">47</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">G key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">48</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">H key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">49</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">I key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">4A</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">J key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">4B</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">K key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">4C</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">L key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">4D</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">M key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">4E</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">N key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">4F</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">O key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">50</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">P key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">51</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Q key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">52</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">R key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">53</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">S key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">54</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">T key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">55</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">U key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">56</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">V key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">57</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">W key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">58</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">X key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">59</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Y key </font></td>
      </tr>
      <tr>
        <td width="34%"></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">5A</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Z key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD0</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">60</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 0 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD1</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">61</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 1 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD2</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">62</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 2 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD3</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">63</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 3 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD4</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">64</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 4 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD5</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">65</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 5 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD6</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">66</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 6 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD7</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">67</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 7 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD8</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">68</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 8 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMPAD9</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">69</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Numeric keypad 9 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SEPARATOR</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">6C</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Separator key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SUBTRACT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">6D</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Subtract key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_DECIMAL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">6E</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Decimal key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_DIVIDE</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">6F</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Divide key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F1</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">70</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F1 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F2</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">71</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F2 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F3</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">72</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F3 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F4</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">73</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F4 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F5</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">74</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F5 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F6</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">75</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F6 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F7</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">76</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F7 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F8</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">77</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F8 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F9</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">78</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F9 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F10</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">79</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F10 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F11</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">7A</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F11 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F12</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">7B</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F12 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F13</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">7C</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F13 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F14</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">7D</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F14 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F15</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">7E</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F15 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F16</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">7F</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F16 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F17</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">80H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F17 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F18</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">81H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F18 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F19</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">82H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F19 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F20</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">83H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F20 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F21</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">84H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F21 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F22</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">85H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F22 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F23</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">86H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F23 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_F24</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">87H</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">F24 key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_NUMLOCK</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">90</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">NUM LOCK key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_SCROLL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">91</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">SCROLL LOCK key </font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_LSHIFT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">A0</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Left SHIFT key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_RSHIFT</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">A1</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Right SHIFT key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_LCONTROL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">A2</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Left CONTROL key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_RCONTROL</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">A3</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Right CONTROL key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_LMENU</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">A4</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Left MENU key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_RMENU</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">A5</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Right MENU key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_PLAY</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">FA</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Play key</font></td>
      </tr>
      <tr>
        <td width="34%"><font face="verdana, geneva, helvetica" size="1">VK_ZOOM</font></td>
        <td width="23%"><font face="verdana, geneva, helvetica" size="1">FB</font></td>
        <td width="43%"><font face="verdana, geneva, helvetica" size="1">Zoom key</font></td>
      </tr>
</TBODY>
    </table>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

