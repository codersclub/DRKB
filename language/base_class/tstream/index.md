---
Title: TStream
Date: 01.01.2007
---


TStream
=======

::: {.date}
01.01.2007
:::

Класс TStream не нов для библиотек фирмы Borland; он и его потомки
называются потоками. Со времен появления в библиотеке Turbo Vision он не
претерпел существенных изменений, но теперь потоки стали обязательными
составными частями там, где нужно прочитать или передать во внешний
источник какую-либо информацию.

TStream \"является абстрактной моделью совокупности данных, обладающей
двумя свойствами --- длиной Size и положением текущего элемента
Position:

property Position: Longint;

property Size: Longint;

От TStream порождены дочерние объекты, позволяющие пользоваться
метафорой потока при работе с файлами, блоками памяти и т. п. Так, в
модуле CLASSES описаны классы TMemoryStream и TFileStream.

Данные потока можно читать или записывать, используя предоставляемый
буфер, или копировать из другого потока. Эта возможность реализована
методами:

function Read(var Buffer; Count: Longint): Longint;virtual; abstract;

function Writetconst Buffer; Count: Longint): Longint;virtual; abstract;

Метод

function Seek(0ffset: Longint; Origin: Word): Longint;virtual; abstract;

позиционирует поток. В зависимости от значения параметра Origin новая
позиция выбирается так:

О --- новая позиция равна Offset;

1 ---текущая позиция смещается на Offset байт;

2 --- новая позиция находится на Offset байт от конца потока.

Методы

procedure ReadBuffer(var Buffer; Count: Longint);

procedure WriteBuffer(const Buffer; Count: Longint);

представляют собой оболочки над Read/Write, вызывающие в случае неудачи
операции исключительные ситуации EReadError/EWriteError.

Метод

function CopyFromfSource: TStream; Count: Longint): Longint;

дописывает к потоку Count байт из потока Source, начиная с его текущей
позиции. Если значение Count равно нулю, то дописывается весь поток
Source с его начала.

Основным отличием реализации TStream в VCL является введение ряда
методов, обеспечивающих чтение и запись компонентов в потоки. Они
полезны на уровне разработчика новых компонентов и здесь подробно не
рассматриваются:

function ReadComponent(Instance: TComponent): TComponent;

function ReadComponentRes(Instance: TComponent): TComponent;

procedure WriteComponent(Instance: TComponent);

procedure WriteComponentRes (const ResName: string;Instance:
TComponent);

procedure ReadResHeader;

TStream
=======

<!-- TOC -->
