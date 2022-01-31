protected void B_INGING22_Click(object sender, EventArgs e)
        {
            //20220111  se implemento
            string path = System.AppDomain.CurrentDomain.BaseDirectory;
            string coma = "/";
            char chcoma = Convert.ToChar(coma);
            string espacio = " ";
            char chespacio = Convert.ToChar(espacio);
            string cero = "0";
            char chcero = Convert.ToChar(cero);




            //DSIng dsi = new DSIng();
            //DSIngTableAdapters.DTimpingresdingresosTableAdapter tai = new DSIngTableAdapters.DTimpingresdingresosTableAdapter();

            //DSPredATableAdapters.predade2022TableAdapter tad = new DSPredATableAdapters.predade2022TableAdapter();
            //DSPredA dsp = new DSPredA();

            DSIng dsi = new DSIng();
            DSIngTableAdapters.Ingresdingresos22TableAdapter tai = new DSIngTableAdapters.Ingresdingresos22TableAdapter();

            DSPredA dsp = new DSPredA();
            DSPredATableAdapters.predade2022TableAdapter tau = new DSPredATableAdapters.predade2022TableAdapter();


            string caja = "0704";
            string ciudad = "CD. GUADALUPE, NUEVO LEON";
            string concepto_2 = " ";
            string concepto_3 = " ";
            string concepto_4 = " ";
            string ctaimporte = "04020006";
            ctaimporte = ctaimporte.PadRight(16, chespacio);

            string ctarecargo = "04320002";
            ctarecargo = ctarecargo.PadRight(16, chespacio);

            string ctasancion = "04320018";
            ctasancion = ctasancion.PadRight(16, chespacio);

            string ctagastos = "04320032";
            ctagastos = ctagastos.PadRight(16, chespacio);

            string ctaotros = "04020007";
            ctaotros = ctaotros.PadRight(16, chespacio);

            string fecha = "20220109";
            string fun = "50";
            string estatusmov = "00";
            string tipo = "PR";
            string centro = "01";
            string con = "1105";
            string efectivo = "";
            string numbanchk = "";
            string numchk = "";
            double dimpchk = 0;
            string numbantc = "";
            string numtc = "YYYYYYYYYY9999";
            string numotr = "";
            string nomotr = "";
          
             double dimpotr = 0;
            string marca = "";
            string rfc = "";
            string poliza = "";
            string fcancont = "";
           
            double destcancont = 0;

            double defectivo = 0;
            double dimpotro = 0;
            double dtid = 0;
            double diva = 0;
            double dcantidad = 0;


            string subcon = "";
            string fcancela = "";
            string hcancela = "";
            string usuario = "";
            string pc = "";
            string usucap = "";
            string horacap = "";
            string numbantd = "";
            string numtd = "";
            double dimptd = 0;
            string refban = "999990000000000";
            double MOV = 0;
            string OFICINA = "";
            string VENTANILLA = "";
            string CTAREF = "";


         Int64 irecibo = 070400000000;


            int ich = 0;

            //string[] lines = System.IO.File.ReadAllLines(path + "\\TRES2019.txt");
            //string[] lines = System.IO.File.ReadAllLines(path + "\\20200120.txt");

            string[] lines = System.IO.File.ReadAllLines(path + "\\1_CONCILIACION_DESCARTE.txt");



            foreach (string line in lines)
            {

                

                

                string spaso = line;
                string[] spasol = spaso.ToString().Split(chcoma);

                string sexp = spasol[0];

                irecibo += 1;
                string recibo = irecibo.ToString();
                recibo = recibo.PadLeft(12, chcero);

                string nombre = spasol[01];
                string direccion = spasol[02];
                string concepto_1 = spasol[03];
                string importe = spasol[04];
                double dimporte = double.Parse(importe);
                string bonimporte = spasol[05];
                double dbonimporte = double.Parse(bonimporte);
                string recargos = spasol[06];
                double drecargos = double.Parse(recargos);
                string bonrecargo = spasol[07];
                double dbonrecargo = double.Parse(bonrecargo);
                string sanciones = spasol[08];
                double dsanciones = double.Parse(sanciones);
                string bonsancion = spasol[09];
                double dbonsancion = double.Parse(bonsancion);
                string gastos = spasol[10];
                double dgastos = double.Parse(gastos);
                string bongastos = spasol[11];
                double dbongastos = double.Parse(bongastos);
                string otros = spasol[12];
                double dotros = double.Parse(otros);
                string bonotros = spasol[13];
                double dbonotros = double.Parse(bonotros);
                string descpp = spasol[14];
                double ddescpp = double.Parse(descpp);
                string referencia = spasol[0];
                referencia = referencia.PadRight(12, chespacio);
                string imptc = spasol[16];
                double dimptc = double.Parse(imptc);
 
                // tai.Uimping(ddimporte, ddbonimporte, ddrecargos, ddbonrecargos, ddsanciones, ddbonsancion, ddgastos, ddbongastos, ddotros, ddbonotros, srecibo);
                // tai.UCon2415(srecibo);
                //tad.DTPO134(sexp);
                // tai.IIng22
                tai.IIng22(fecha, recibo, caja, nombre, direccion, ciudad, concepto_1, concepto_2, concepto_3, concepto_4, ctaimporte, dimporte, dbonimporte, ctarecargo, drecargos, dbonrecargo, ctasancion, dsanciones, dbonsancion, ctagastos, dgastos, dbongastos, ctaotros, dotros, dbonotros, fun, estatusmov, tipo, centro, ddescpp, con, referencia, defectivo, numbanchk, numchk, dimpchk, numbantc, numtc, dimptc, numotr,nomotr, dimpotro, marca, rfc, poliza, fcancont, destcancont, dtid, diva, subcon, fcancela, hcancela, usuario, pc, dcantidad, usucap, horacap, numbantd, numtd,dimptd, MOV, refban, OFICINA, VENTANILLA, CTAREF);
              //  tau.Usalimpsalsub22_desccon(sexp);

                ich += 1;

            }

            LABELYATERMINE.InnerText = "YA TERMINE DELETE  =  " + ich;

        }
    }

 string  ctafolio = "00000000000000";
 string  cuenta = "00000000";
 string  caja = "0806";
 string  estatus = "0000";
 string  fun = "50";
 string  fpago = "20220113";
 string  ofipago = "0801";
 string  fcancont = "        ";
 int  numunico = 0;
 double  indiceini = "0";
 double  indicefin = "0";
 string  yearindini = "      ";
 string  yearindfin	 = "     ";
 string refban	= " ";
 string USUCAPBON	= " ";
 string FDESCAR	 = " ";
 int DEVEN	= 0;

 string exp = "14";	
 string yearbim	= spasol[01];
 double montoimp	= spasol[01];
 double bonif	= spasol[01];
 string recibo	= spasol[01];
 string region	= spasol[01];
 string regman	= spasol[01];
 double subsidio= spasol[01];	

