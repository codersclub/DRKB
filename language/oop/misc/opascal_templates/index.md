---
Title: Шаблоны в Object Pascal
Date: 01.01.2007
---


Шаблоны в Object Pascal
=======================

::: {.date}
01.01.2007
:::

Шаблоны в Object Pascal

( перевод одноименной статьи с сайта community.borland.com )

Наверное каждый Delphi программист хоть раз общался с программистом C++
и объяснял насколько
Delphi мощнее и удобнее. Но в некоторый момент, программист C++ заявляет
примерно следующее

"OK, но Delphi использует Pascal, а значит не поддерживает
множественное наследование и шаблоны,
поэтому он не так хорош как C++."

Насчет множественного наследования можно легко заявить, что Delphi имеет
интерфейсы, которые
прекрасно справляются со своей задачей, но вот насчет шаблонов Вам
придётся согласится, так как
Object Pascal не поддерживает их.

Давайте посмотрим на эту проблему по-внимательней

Шаблоны позволяют делать универсальные контейнеры такие как списки,
стеки, очереди, и т.д.

Если Вы хотите осуществить что-то подобное в Delphi, то у Вас есть два
пути:

- Использовать контейнер TList, который содержит указатели. В этом случае
Вам придётся всё
время делать явное приведение типов.

- Сделать подкласс контейнера TCollection или TObjectList, и убрать все
методы, зависящие от типов
каждый раз, когда Вы захотите использовать новый тип данных.

- Третий вариант, это сделать модуль с универсальным классом контейнера, и
каждый раз, когда нужно
использовать новый тип данных, нам прийдётся в редакторе искать и
вносить исправления. Было бы
здорово, если всю эту работу за Вас делал компилятор....
вот этим мы сейчас и займёмся!

Например, возьмём классы TCollection и TCollectionItem. Когда Вы
объявляете нового потомка TCollectionItem,
то так же Вы наследуете новый класс от TOwnedCollection и
переопределяете большинство методов, чтобы
их можно было вызывать  с новыми типами.

Давайте посмотрим, как создать универсальную коллекцию шаблонов класса:

Шаг 1:
Создайте новый текстовый файл (не юнитовский) с именем
TemplateCollectionInterface.pas:

    _COLLECTION_ = class (TOwnedCollection)
    protected
     function  GetItem (const aIndex : Integer) : _COLLECTION_ITEM_;
     procedure SetItem (const aIndex : Integer;
                        const aValue : _COLLECTION_ITEM_);
    public
     constructor Create (const aOwner : TComponent);
     
     function Add                                 : _COLLECTION_ITEM_;
     function FindItemID (const aID    : Integer) : _COLLECTION_ITEM_;
     function Insert     (const aIndex : Integer) : _COLLECTION_ITEM_;
     property Items      [const aIndex : Integer] : _COLLECTION_ITEM_ read GetItem write SetItem;
    end;

Обратите внимание, что нет никаких uses или interface clauses, только
универсальное объявление
типа, в котором \_COLLECTION\_ это имя универсальной коллекции класса, а
\_COLLECTION\_ITEM\_
это имя методов, содержащихся в нашем шаблоне.

Шаг 2:
Создайте второй текстовый файл и сохраните его как
TemplateCollectionImplementation.pas:

    constructor _COLLECTION_.Create (const aOwner : TComponent);
    begin
     inherited Create (aOwner, _COLLECTION_ITEM_);
    end;
     
    function _COLLECTION_.Add : _COLLECTION_ITEM_;
    begin
     Result := _COLLECTION_ITEM_ (inherited Add);
    end;
     
    function _COLLECTION_.FindItemID (const aID : Integer) : _COLLECTION_ITEM_;
    begin
     Result := _COLLECTION_ITEM_ (inherited FindItemID (aID));
    end;
     
    function _COLLECTION_.GetItem (const aIndex : Integer) : _COLLECTION_ITEM_;
    begin
     Result := _COLLECTION_ITEM_ (inherited GetItem (aIndex));
    end;
     
    function _COLLECTION_.Insert (const aIndex : Integer) : _COLLECTION_ITEM_;
    begin
     Result := _COLLECTION_ITEM_ (inherited Insert (aIndex));
    end;
     
    procedure _COLLECTION_.SetItem (const aIndex : Integer;
                                    const aValue : _COLLECTION_ITEM_);
    begin
     inherited SetItem (aIndex, aValue);
    end;

Снова нет никаких uses или interface clauses, а только код
универсального типа.

Шаг 3:
Создайте новый unit-файл с именем MyCollectionUnit.pas:

    unit MyCollectionUnit;
     
    interface
     
    uses Classes;
     
    type TMyCollectionItem = class (TCollectionItem)
         private
          FMyStringData  : String;
          FMyIntegerData : Integer;
         public
          procedure Assign (aSource : TPersistent); override;
         published
          property MyStringData  : String  read FMyStringData  write FMyStringData;
          property MyIntegerData : Integer read FMyIntegerData write FMyIntegerData;
         end;
     
         // !!! Указываем универсальному классу на реальный тип
     
         _COLLECTION_ITEM_ = TMyCollectionItem; 
     
         // !!! директива добавления интерфейса универсального класса
     
         {$INCLUDE TemplateCollectionInterface} 
     
         // !!! переименовываем универсальный класс
     
         TMyCollection = _COLLECTION_;          
     
    implementation
     
    uses SysUtils;
     
    // !!! препроцессорная директива добавления универсального класса
     
    {$INCLUDE TemplateCollectionImplementation} 
     
    procedure TMyCollectionItem.Assign (aSource : TPersistent);
    begin
     if aSource is TMyCollectionItem then
     begin
      FMyStringData  := TMyCollectionItem(aSource).FMyStringData;
      FMyIntegerData := TMyCollectionItem(aSource).FMyIntegerData;
     end
     else inherited;
    end;
     
    end.

Вот и всё! Теперь компилятор будет делать всю работу за Вас! Если Вы
измените интерфейс
универсального класса, то изменения автоматически распространятся на все
модули, которые
он использует.

Второй пример

Давайте создадим универсальный класс для динамических массивов.

Шаг 1:
Создайте текстовый файл с именем TemplateVectorInterface.pas:

    _VECTOR_INTERFACE_ = nterface
     function  GetLength : Integer;
     procedure SetLength (const aLength : Integer);
     
     function  GetItems (const aIndex : Integer) : _VECTOR_DATA_TYPE_;
     procedure SetItems (const aIndex : Integer;
                         const aValue : _VECTOR_DATA_TYPE_);
     
     function  GetFirst : _VECTOR_DATA_TYPE_;
     procedure SetFirst (const aValue : _VECTOR_DATA_TYPE_);
     
     function  GetLast  : _VECTOR_DATA_TYPE_;
     procedure SetLast  (const aValue : _VECTOR_DATA_TYPE_);
     
     function  High  : Integer;
     function  Low   : Integer;
     
     function  Clear                              : _VECTOR_INTERFACE_;
     function  Extend   (const aDelta : Word = 1) : _VECTOR_INTERFACE_;
     function  Contract (const aDelta : Word = 1) : _VECTOR_INTERFACE_; 
     
     property  Length                         : Integer             read GetLength write SetLength;
     property  Items [const aIndex : Integer] : _VECTOR_DATA_TYPE_  read GetItems  write SetItems; default;
     property  First                          : _VECTOR_DATA_TYPE_  read GetFirst  write SetFirst;
     property  Last                           : _VECTOR_DATA_TYPE_  read GetLast   write SetLast;
    end;
     
    _VECTOR_CLASS_ = class (TInterfacedObject, _VECTOR_INTERFACE_)
    private
     FArray : array of _VECTOR_DATA_TYPE_;
    protected
     function  GetLength : Integer;
     procedure SetLength (const aLength : Integer);
     
     function  GetItems (const aIndex : Integer) : _VECTOR_DATA_TYPE_;
     procedure SetItems (const aIndex : Integer;
                         const aValue : _VECTOR_DATA_TYPE_);
     
     function  GetFirst : _VECTOR_DATA_TYPE_;
     procedure SetFirst (const aValue : _VECTOR_DATA_TYPE_);
     
     function  GetLast  : _VECTOR_DATA_TYPE_;
     procedure SetLast  (const aValue : _VECTOR_DATA_TYPE_);
    public
     function  High  : Integer;
     function  Low   : Integer;
     
     function  Clear                              : _VECTOR_INTERFACE_;
     function  Extend   (const aDelta : Word = 1) : _VECTOR_INTERFACE_;
     function  Contract (const aDelta : Word = 1) : _VECTOR_INTERFACE_; 
     
     constructor Create (const aLength : Integer);
    end;

Шаг 2:
Создайте текстовый файл и сохраните его как
TemplateVectorImplementation.pas:

    constructor _VECTOR_CLASS_.Create (const aLength : Integer);
    begin
     inherited Create;
     SetLength (aLength);
    end;
     
    function _VECTOR_CLASS_.GetLength : Integer;
    begin
     Result := System.Length (FArray);
    end;
     
    procedure _VECTOR_CLASS_.SetLength (const aLength : Integer);
    begin
     System.SetLength (FArray, aLength);
    end;
     
    function _VECTOR_CLASS_.GetItems (const aIndex : Integer) : _VECTOR_DATA_TYPE_;
    begin
     Result := FArray [aIndex];
    end;
     
    procedure _VECTOR_CLASS_.SetItems (const aIndex : Integer;
                                       const aValue : _VECTOR_DATA_TYPE_);
    begin
     FArray [aIndex] := aValue;
    end;
     
    function _VECTOR_CLASS_.High : Integer;
    begin
     Result := System.High (FArray);
    end;
     
    function _VECTOR_CLASS_.Low : Integer;
    begin
     Result := System.Low (FArray);
    end;
     
    function _VECTOR_CLASS_.GetFirst : _VECTOR_DATA_TYPE_;
    begin
     Result := FArray [System.Low (FArray)];
    end;
     
    procedure _VECTOR_CLASS_.SetFirst (const aValue : _VECTOR_DATA_TYPE_);
    begin
     FArray [System.Low (FArray)] := aValue;
    end;
     
    function _VECTOR_CLASS_.GetLast : _VECTOR_DATA_TYPE_;
    begin
     Result := FArray [System.High (FArray)];
    end;
     
    procedure _VECTOR_CLASS_.SetLast (const aValue : _VECTOR_DATA_TYPE_);
    begin
     FArray [System.High (FArray)] := aValue;
    end;
     
    function _VECTOR_CLASS_.Clear : _VECTOR_INTERFACE_;
    begin
     FArray := Nil;
     Result := Self;
    end;
     
    function _VECTOR_CLASS_.Extend (const aDelta : Word) : _VECTOR_INTERFACE_;
    begin
     System.SetLength (FArray, System.Length (FArray) + aDelta);
     Result := Self;
    end;
     
    function _VECTOR_CLASS_.Contract (const aDelta : Word) : _VECTOR_INTERFACE_;
    begin
     System.SetLength (FArray, System.Length (FArray) - aDelta);
     Result := Self;
    end;

Шаг 3:
Создайте unit файл с именем FloatVectorUnit.pas:

    unit FloatVectorUnit;
     
    interface
     
    uses Classes;                           // !!! Модуль "Classes" содержит объявление класса TInterfacedObject
     
    type _VECTOR_DATA_TYPE_ = Double;       // !!! тип данных для класса массива Double
     
         {$INCLUDE TemplateVectorInterface}
     
         IFloatVector = _VECTOR_INTERFACE_; // !!! give the interface a meanigful name
         TFloatVector = _VECTOR_CLASS_;     // !!! give the class a meanigful name
     
    function CreateFloatVector (const aLength : Integer = 0) : IFloatVector; // !!! дополнительная функция 
     
    implementation
     
    {$INCLUDE TemplateVectorImplementation}
     
    function CreateFloatVector (const aLength : Integer = 0) : IFloatVector;     
    begin
     Result := TFloatVector.Create (aLength);
    end;
     
    end.

Естественно, можно дополнить универсальный класс дополнительными
функциями. Всё зависит от Вашей фантазии!

Использование шаблонов

Вот пример использования нового векторного интерфейса:

    procedure TestFloatVector;
     var aFloatVector : IFloatVector;
         aIndex       : Integer;
    begin
     aFloatVector := CreateFloatVector;
     
     aFloatVector.Extend.Last := 1;
     aFloatVector.Extend.Last := 2;
     
     for aIndex := aFloatVector.Low to aFloatVector.High do
     begin
      WriteLn (FloatToStr (aFloatVector [aIndex]));
     end;
    end.

Единственное требование при создании шаблонов таким способом, это то, что
каждый новый тип должен быть объявлен в отдельном модуле, а так же Вы должны
иметь исходники для универсальных классов.

Комментарии и вопросы присылайте по адресу rossen\_assenov@yahoo.com!

Взято из <https://forum.sources.ru>
