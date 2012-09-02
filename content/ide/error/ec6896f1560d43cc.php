<h1>IDE highlighting the incorrect line</h1>
<div class="date">01.01.2007</div>


<p>On one project, the IDE insists on highlighting the incorrect line</p>
<p>for different conditions. For example, when a syntax error is</p>
<p>highlighted, the line above the error is highlighted or when I set</p>
<p>breakpoints by choosing a blue dot in the gutter, it does not</p>
<p>"line up" with the text line. How can I fix this?</p>
<p>This condition is usually caused by opening the file in a different</p>
<p>editor than the editor provided by the IDE. If a line of code is</p>
<p>somehow modified and then saved back to the disk using only a carriage</p>
<p>return for a line terminating character (instead of a carriage return</p>
<p>+ line feed sequence), the IDE may get confused. To fix the problem,</p>
<p>load the file into an editor that will save each line with a carriage</p>
<p>return + line feed sequence.</p>
<p class="note">Примечание от Vit: ошибка исправлена в Дельфи 7.</p>
