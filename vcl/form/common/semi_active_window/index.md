---
Title: Наполовину активное окно
Date: 01.01.2007
---


Наполовину активное окно
========================

::: {.date}
01.01.2007
:::

Как сделать так, чтобы окно было неактивно? Вы скажите: \"Ничего
сложного. Нужно только свойство окна Enabled установить в false\"\...
но, так как окно является владельцем компонентов, находящихся на нём, то
и все компоненты станут неактивными!

Но был найден способ избежать этого!

    private
      { Private declarations }
      procedure WMNCHitTest (var M: TWMNCHitTest); message wm_NCHitTest;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.WMNCHitTest (var M:TWMNCHitTest);
    begin
      if M.Result = htClient then
        M.Result := htCaption;
    end;

Взято с <https://delphiworld.narod.ru>
