---
Title: Как отобразить модально MDI Child форму?
Author: Girder
Date: 01.01.2007
---


Как отобразить модально MDI Child форму?
========================================

::: {.date}
01.01.2007
:::

Как выполнить код после создания MDIChild-формы но до появления ее на
экране?

Как отобразить MDIChild-форму модально?

1.Убераешь свою MDIChild форму из автосоздания: (MainMenu)
Project-\>Options-\>Forms. Там её перебрасываешь в: Available forms

2. Переключаешься на свою MDIChild форму и дописываеш в описание
класса(пусть например твой класс формы для MDIChild называется TForm2):

     TForm2 = class(TForm)
        ...
        procedure CreateWindowHandle(const Params: TCreateParams); override;
      private
        { Private declarations }
      public
     

3. Реализуешь эту процедуру:

    procedure TForm2.CreateWindowHandle(const Params: TCreateParams);
    var Comp:TForm2;
    begin
     inherited;
     Comp:=TForm2(Application.Components[Application.ComponentCount-1]);
     Comp.Visible:=false;
    end;

     
    uses Unit2; //ссылка на модуль MDIChild формы
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var vv:TForm2;
    begin
     vv:=TForm2.Create(Application);
     //... Здесь форма не видна
     vv.Memo1.Lines.Add('123123'); //Типо что-то заполняем на MDIChild форме
     Caption:='2';
     Sleep(2000);
     Caption:='0';
     //.. Здесь форма до сих пор не видна
     vv.Show;
    end;

Автор: Girder

Взято с Vingrad.ru <https://forum.vingrad.ru>
