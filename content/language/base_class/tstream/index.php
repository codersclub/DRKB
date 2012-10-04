<h1>TStream</h1>
<div class="date">01.01.2007</div>


<p>Класс TStream не нов для библиотек фирмы Borland; он и его потомки называются потоками. Со времен появления в библиотеке Turbo Vision он не претерпел существенных изменений, но теперь потоки стали обязательными составными частями там, где нужно прочитать или передать во внешний источник какую-либо информацию.</p>
<p>TStream "является абстрактной моделью совокупности данных, обладающей двумя свойствами &#8212; длиной Size и положением текущего элемента Position:</p>
<p>property Position: Longint;</p>
<p>property Size: Longint;</p>
<p>От TStream порождены дочерние объекты, позволяющие пользоваться метафорой потока при работе с файлами, блоками памяти и т. п. Так, в модуле CLASSES описаны классы TMemoryStream и TFileStream.</p>
<p>Данные потока можно читать или записывать, используя предоставляемый буфер, или копировать из другого потока. Эта возможность реализована методами:</p>
<p>function Read(var Buffer; Count: Longint): Longint;virtual; abstract;</p>
<p>function Writetconst Buffer; Count: Longint): Longint;virtual; abstract;</p>
<p>Метод</p>
<p>function Seek(0ffset: Longint; Origin: Word): Longint;virtual; abstract;</p>
<p>позиционирует поток. В зависимости от значения параметра Origin новая позиция выбирается так:</p>
<p>О &#8212; новая позиция равна Offset;</p>
<p>1 &#8212;текущая позиция смещается на Offset байт;</p>
<p>2 &#8212; новая позиция находится на Offset байт от конца потока.</p>
<p>Методы</p>
<p>procedure ReadBuffer(var Buffer; Count: Longint);</p>
<p>procedure WriteBuffer(const Buffer; Count: Longint);</p>
<p>представляют собой оболочки над Read/Write, вызывающие в случае неудачи операции исключительные ситуации EReadError/EWriteError.</p>
<p>Метод</p>
<p>function CopyFromfSource: TStream; Count: Longint): Longint;</p>
<p>дописывает к потоку Count байт из потока Source, начиная с его текущей позиции. Если значение Count равно нулю, то дописывается весь поток Source с его начала.</p>
<p>Основным отличием реализации TStream в VCL является введение ряда методов, обеспечивающих чтение и запись компонентов в потоки. Они полезны на уровне разработчика новых компонентов и здесь подробно не рассматриваются:</p>
<p>function ReadComponent(Instance: TComponent): TComponent;</p>
<p>function ReadComponentRes(Instance: TComponent): TComponent;</p>
<p>procedure WriteComponent(Instance: TComponent);</p>
<p>procedure WriteComponentRes (const ResName: string;Instance: TComponent);</p>
<p>procedure ReadResHeader;</p>

<h1>TStream</h1>

