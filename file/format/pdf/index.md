---
Title: Как работать с PDF файлами?
Date: 01.01.2007
---


Как работать с PDF файлами?
===========================

::: {.date}
01.01.2007
:::

Let\'s see how to to show an Adobe Acrobat (.PDF) file in a Delphi
application. All you need to do is the Acrobat ActiveX control (pdf.ocx
and pdf.tlb), which you you can get for free from Adobe.

Here\'s How:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -----------------------------------------------------------------
  ·   Start Delphi and select Component \| Import ActiveX Control...
  --- -----------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ------------------------------------------------------------------------------------------
  ·   Look for the \'Acrobat Control for ActiveX (Version x.x)\'  and simply click on Install.
  --- ------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ------------------------------------------------------------------------------------
  ·   Select the Component palette location in which you want to place selected library.
  --- ------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ---------------------------------------------------------
  ·   Maybe the best is to leave the ActiveX option selected.
  --- ---------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -------------------
  ·   Click on Install.
  --- -------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ----------------------------------------------------------------------------------------------------------------------------
  ·   Select a package where the new component must be installed or create a new package for the new TPdf control.  Click on OK.
  --- ----------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ----------------------------------------------------------------------------------------------------
  ·   Delphi will prompt you whether you want to rebuild the modified/new package or not.  Click on Yes.
  --- ----------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -----------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   After the package is compiled, Delphi will show you a message saying that the new TPdf component was registered and already available as part of the VCL.
  --- -----------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -----------------------------------------------------------------------------
  ·   Close the package detail window, allowing Delphi to save the changes to it.
  --- -----------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ---------------------------------------------------------------------------------------------------
  ·   The component is now available in the ActiveX tab (if you didn\'t change this setting in step 4) 
  --- ---------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -------------------------------
  ·   Drop the component on a form.
  --- -------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -------------------------------------------------------------
  ·   Select the TPdf component you just dropped on a blank form.
  --- -------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Using the object inspector, set the src property to the name of an existing PDF file on your system. Now all you have to do is resize the component and read the PDF file from your Delphi application.
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

Tips:

If you do not have the Acrobat ActiveX control, download it
nowhttp://www.adobe.com/prodindex/acrobat/readstep.html! It will be
required for tip to work.

Last step (Step 15) can be done in runtime, so you can open and close
files programmatically, as well as resize the control.

Closing acrobat reader on formdestroy:

    procedure Tfrm_doc_pdf.FormDestroy(Sender: TObject);
    var
      xHWND: integer;
    begin
      xHWND := findwindow(nil, 'Acrobat Reader');
      sendmessage(xHWND, WM_CLOSE, 0, 0);
    end;

------------------------------------------------------------------------

Ok, you must have installed the Acrobat Reader program in your machine,
if you donґt have it you can download it from Adobeґs site:
www.adobe.comhttp://www.adobe.com

After that you have to install the type library for Acrobat (Project -\>
Import Type Library from Delphiґs menu) select "Acrobat Control for
ActiveX (version x)". Where x stands for the current version of the
type library. Click the install button to install it into the IDE.

Now, Start a new Application, drop from whatever page of the component
palette you have installed a TPDF component in a form, next add an
OpenDialog, and finally a Button, in the Onclick event of the Button
use:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if OpenDialog1.Execute then
        pdf1.src := OpenDialog1.FileName;
    end;

in PdfLib\_TLB Unit you can find the interface of the TPdf class in
order to know the behaviour of that class so here it is:

    TPdf = class(TOleControl)
    private
      FIntf: _DPdf;
      function GetControlInterface: _DPdf;
    protected
      procedure CreateControl;
      procedure InitControlData; override;
    public
      function LoadFile(const fileName: WideString): WordBool;
      procedure setShowToolbar(On_: WordBool);
      procedure gotoFirstPage;
      procedure gotoLastPage;
      procedure gotoNextPage;
      procedure gotoPreviousPage;
      procedure setCurrentPage(n: Integer);
      procedure goForwardStack;
      procedure goBackwardStack;
      procedure setPageMode(const pageMode: WideString);
      procedure setLayoutMode(const layoutMode: WideString);
      procedure setNamedDest(const namedDest: WideString);
      procedure Print;
      procedure printWithDialog;
      procedure setZoom(percent: Single);
      procedure setZoomScroll(percent: Single; left: Single; top:
        Single);
      procedure setView(const viewMode: WideString);
      procedure setViewScroll(const viewMode: WideString; offset:
        Single);
      procedure setViewRect(left: Single; top: Single; width: Single;
        height: Single);
      procedure printPages(from: Integer; to_: Integer);
      procedure printPagesFit(from: Integer; to_: Integer; shrinkToFit:
        WordBool);
      procedure printAll;
      procedure printAllFit(shrinkToFit: WordBool);
      procedure setShowScrollbars(On_: WordBool);
      procedure AboutBox;
      property ControlInterface: _DPdf read GetControlInterface;
      property DefaultInterface: _DPdf read GetControlInterface;
    published
      property TabStop;
      property Align;
      property DragCursor;
      property DragMode;
      property ParentShowHint;
      property PopupMenu;
      property ShowHint;
      property TabOrder;
      property Visible;
      property OnDragDrop;
      property OnDragOver;
      property OnEndDrag;
      property OnEnter;
      property OnExit;
      property OnStartDrag;
      property src: WideString index 1 read GetWideStringProp write
        SetWideStringProp stored False;
    end;

finally hereґs an advice:

You canґt be sure your users will have Acrobat Reader installed so
please fisrt check that situation before you take any actions with the
TPdf component. And second if your PDF file have links for an AVI file
for example, they donґt work from Delphi.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
