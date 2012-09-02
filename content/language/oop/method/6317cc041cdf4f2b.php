<h1>Перекрытие виртуальных методов</h1>
<div class="date">01.01.2007</div>


<p>Кто-нибудь знает, в чем разница между перекрытием (OVERRIDING) виртуального метода и заменой (REPLACING) его? Я немного запутался.</p>

<p>Допустим у вас есть класс:</p>
<pre>
TMyObject = class (TObject) 
</pre>

<p>и его наследник:</p>
<pre>
TOverrideObject = class (TMyObject) 
</pre>

<p>К примеру, TMyObject имеет метод Wiggle:</p>

<pre>
procedure Wiggle; virtual; 
</pre>

<p>а TOverrideObject перекрывает Wiggle:</p>

<pre>
procedure Wiggle; override; 
</pre>

<p>и, естественно, вы реализовали оба метода.</p>

<p>Теперь вы создаете TList, содержащий целую кучу MyObjects и OverrideObjects в свойстве TList.Items[n]. Свойство Items является указателем, поэтому для вызова метода Wiggle вам достаточно вызвать необходимый элемент списка. Например так:</p>

<pre>
if TObject(Items[1]) is TMyObject then 
  TMyObject(Items[1]).Wiggle
else 
  if TObject(Items[1]) is TOverrideObject then 
    TOverrideObject(Items[1]).Wiggle;
</pre>

<p>но возможности полиморфизма и директива override позволяют вам сделать так:</p>

<pre>
TMyObject(Items[1]).Wiggle; 
</pre>

<p>Ваше приложение посмотрит на экземпляр специфического объекта, ссылка на который содержится в Items[1] и скажет: "Да, это - TMyObject, но, точнее говоря, это TOverrideObject; но поскольку метод Wiggle является виртуальным методом и TOverrideObject переопределил метод Wiggle, я собираюсь выполнить метод TOverrideObject.Wiggle, а не метод TMyObject.Wiggle."</p>

<p>Теперь представьте себе, что при декларации метода вы пропустили директиву override, попробуйте это выполнить теперь:</p>

<pre>
TMyObject(Items[1]).Wiggle; 
</pre>

<p>Приложение и в этом случае должно "видеть" данный метод, даже если Items[1] - TOverrideObject; но у него отсутствует перекрытая версия метода Wiggle, поэтому приложение выполнит TMyObject.Wiggle, а не TOverrideObject.Wiggle (поведение, которое вы можете как хотеть, так и избегать).</p>

<p>Так, перекрытый метод функционально может отличаться от декларированного метода, содержащего директиву virtual (или dynamic) в базовом классе, и объявленный с директивой override в классе-наследнике. Для замены метода необходимо объявить его в классе-наследнике без директивы override. Перекрытые методы могут выполняться даже тогда, когда специфический экземпляр класса-предка является точной копией базового класса. "Замененные" методы могут выполняться только тогда, когда специфический экземпляр является "слепком" только этого класса.</p>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

