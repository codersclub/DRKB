---
Title: Каким обpазом выбиpать pазмеp шpифта?
Author: Garik Pozdeev (2:5021/15.9)
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Каким обpазом выбиpать pазмеp шpифта?
=====================================

> OpneGL: Каким обpазом выбиpать pазмеp шpифта, т.к. все мои стpадания по
> выбоpy паpаметpов шpифта в CreateFont() никак не отpажались на его
> pазмеpе?

Все что я пpидyмал, это юзать glScale(), но в этом слyчае полyчаем
плохое качество (по сpавнению с той-же Воpдой) пpи малом pазмеpе
символов. Вот часть работающего примера на Си (переведенного мною на
Паскаль (АА)).

    procedure GLSetupRC( pData: Pointer )
    //void GLSetupRC(void *pData)
    //{
    var
    //  HDC hDC;
    hDC: HDC;
    //  HFONT hFont;
    hFont: HFONT;
    //  GLYPHMETRICSFLOAT agmf[128];
    agmf: array [0..127] of GLYPHMETRICSFLOAT;
    //  LOGFONT logfont;
    logfont: LOGFONT;
     
    begin
     
     logfont.lfHeight := -10;
     logfont.lfWidth := 0;
     logfont.lfEscapement := 0;
     logfont.lfOrientation := 0;
     logfont.lfWeight := FW_BOLD;
     logfont.lfItalic := FALSE;
     logfont.lfUnderline := FALSE;
     logfont.lfStrikeOut := FALSE;
     logfont.lfCharSet := ANSI_CHARSET;
     logfont.lfOutPrecision := OUT_DEFAULT_PRECIS;
     logfont.lfClipPrecision := CLIP_DEFAULT_PRECIS;
     logfont.lfQuality := DEFAULT_QUALITY;
     logfont.lfPitchAndFamily := DEFAULT_PITCH;
     //strcpy(logfont.lfFaceName,"Arial");
     //strcpy(logfont.lfFaceName,"Decor");
     StrPCopy( logfont.lfFaceName, 'Decor' );
     
     glDepthFunc(GL_LESS);
     glEnable(GL_DEPTH_TEST);  // Hidden surface removal
     glFrontFace(GL_CCW);      // Counter clock-wise polygons face out
     glEnable(GL_CULL_FACE);   // Do not calculate insides
     glShadeModel(GL_SMOOTH);  // Smooth shading
     glEnable(GL_AUTO_NORMAL);
     glEnable(GL_NORMALIZE);
     glEnable(GL_COLOR_MATERIAL);
     
     glClearColor(0.0, 0.0, 0.0, 1.0 );
     
     glEnable(GL_LIGHTING);
     glLightfv(GL_LIGHT0,GL_AMBIENT,ambientLight);
     glLightfv(GL_LIGHT0,GL_DIFFUSE,diffuseLight);
     glLightfv(GL_LIGHT0,GL_SPECULAR,specular);
     glLightfv(GL_LIGHT0,GL_POSITION,lightPos);
     glEnable(GL_LIGHT0);
     
     glColorMaterial(GL_FRONT, GL_AMBIENT_AND_DIFFUSE);
     
     glMaterialfv(GL_FRONT, GL_SPECULAR,specular);
     glMateriali(GL_FRONT,GL_SHININESS,100);
     
     // Blue 3D Text
     glRGB(0, 0, 255);
     
     // Select the font into the DC
     hDC := (HDC)pData;
     //  hFont = CreateFontIndirect(&logfont);
     hFont := CreateFontIndirect( Addr(logfont) );
     SelectObject (hDC, hFont);
     
     //create display lists for glyphs 0 through 255 with 0.3 extrusion
     // and default deviation. The display list numbering starts at 1000
     // (it could be any number).
     
     //  if(!wglUseFontOutlines(hDC, 0, 128, 1000, 0., 0.3,
     //                            WGL_FONT_POLYGONS, agmf))
     if not wglUseFontOutlines(hDC, 0, 128, 1000, 0., 0.3,
     
     //>                                         ``` - это тебе поможет
     //> Выводить текст можно в любым масштабе
     
                               WGL_FONT_POLYGONS, agmf) then
     
        Windows.MessageBox(nil,'Could not create Font Outlines',
                        'Error',MB_OK or MB_ICONSTOP);
     
     // Delete the font now that we are done
     
     DeleteObject(hFont);
    //}
    end;
     
    // void GLRenderScene(void *pData)
    procedure GLRenderScene(pData: Pointer);
    begin
     (*  ...  *)
     
     // Draw 3D text
     glListBase(1000);
     glPushMatrix();
     // Set up transformation to draw the string.
     glTranslatef(-35.0, 0.0, -5.0);
     glScalef(60.0, 60.0, 60.0);
     glCallLists(3, GL_UNSIGNED_BYTE, 'Decor');
     glPopMatrix();  // Clear the window with current clearing color
     
     (* ... *)
    end;

Автор: StayAtHome

