using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Management;
using System.Net;
using System.IO;
using System.Threading;

namespace HWID
{
    public partial class LoginWindow : Form
    {
        string path;
        public string userHWID;
        Settings settings = new Settings();

        public LoginWindow()
        {
            InitializeComponent();
            userHWID = GenerateHWID();
            string computerName = Dns.GetHostName();
            computerName = computerName.Split('-')[0];
            string path2 = "C:\\Users\\" + computerName + "\\AppData\\Local";
            path = "C:\\Users\\" + computerName + "\\AppData\\Local\\username.hwid";

            if (!Directory.Exists(path2))
                path = "username.hwid";

            if (File.Exists(path))
            {
                using (StreamReader sr = new StreamReader(path))
                {
                    txtUsername.AppendText(sr.ReadLine());
                    cmdUsername.Enabled = false;
                    txtUsername.Enabled = false;
                    txtKey.Enabled = true;
                }
            }
            userHWID += "-" + txtUsername.Text;
        }
        private string GenerateHWID()
        {
            string cpuInfo = string.Empty;
            ManagementClass mc = new ManagementClass("win32_processor");
            ManagementObjectCollection moc = mc.GetInstances();
            foreach (ManagementObject mo in moc)
            {
                if (cpuInfo == "")
                {
                    cpuInfo = mo.Properties["processorID"].Value.ToString();
                    break;
                }
            }
            return cpuInfo;
        }

        private void Login()
        {
            try
            {
                WebClient wClient = new WebClient();
                string strSource = wClient.DownloadString(settings.URL_HWID + "index.php?a=canuse&hwid=" + userHWID + "&product=" + settings.product);
                if (strSource.Contains("TRUE"))
                {
                    strSource = wClient.DownloadString(settings.URL_HWID + "index.php?a=checkdate&hwid=" + userHWID);
                    if (strSource.Contains(settings.product)) // Das Datum prüfen
                    {
                        int start = strSource.IndexOf(settings.product) + settings.product.Length;
                        int end = strSource.IndexOf(":" + settings.product);
                        DateTime date = Convert.ToDateTime(strSource.Substring(start, end - start));

                        strSource = wClient.DownloadString("http://weltzeit4u.com/Datum/index.php"); // Das aktuelle Datum holen
                        int start2 = strSource.IndexOf("<span id='gross_fett_blau'>") + 27;
                        int end2 = strSource.IndexOf("</span> (arabische");
                        string dateToday = strSource.Substring(start2, end2 - start2) + " 00:00:00";
                        if (date < Convert.ToDateTime(dateToday))
                        {
                            MessageBox.Show("Deine Lizenz ist abgelaufen", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
                            return;
                        }
                        this.Hide();
                        MemberArea form = new MemberArea();
                        form.Show();
                    }
                }
                else
                {
                    MessageBox.Show("Das Programm wurde noch nicht freigeschaltet", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void cmdUsername_Click(object sender, EventArgs e)
        {
            if (txtUsername.Text != "")
            {
                DialogResult result = MessageBox.Show("Ist der Name " + txtUsername.Text + " richtig?", "Sicher?", MessageBoxButtons.YesNo, MessageBoxIcon.Question);
                if (result == DialogResult.Yes)
                {
                    try
                    {
                        using (StreamWriter sw = new StreamWriter(path))
                        {
                            sw.WriteLine(txtUsername.Text);
                        }
                    }
                    catch
                    {
                    }
                    userHWID += txtUsername.Text;
                    cmdUsername.Enabled = false;
                    txtUsername.Enabled = false;
                    txtKey.Enabled = true;
                }
                else
                    return;
            }
            else
                MessageBox.Show("Bitte einen Username eingeben", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }

        private void cmdRegister_Click(object sender, EventArgs e)
        {
            try
            {
                if (txtKey.Text != "")
                {
                    WebClient wClient = new WebClient();
                    string strSource = wClient.DownloadString(settings.URL_HWID + "index.php?a=register&key=" + txtKey.Text + "&hwid=" + userHWID + "&product=" + settings.product);
                    txtKey.Text = "";
                    if (strSource.Contains("wrong key"))
                        MessageBox.Show("Key ist falsch", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    else if (strSource.Contains("wrong hwid"))
                        MessageBox.Show("HWID fehlt", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    else if (strSource.Contains("key is already in use"))
                        MessageBox.Show("Key wurde schon benutzt", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    else
                        Login();
                }
                else
                    MessageBox.Show("Bitte einen Key eingeben", "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Fehler", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void cmdLogin_Click(object sender, EventArgs e)
        {
            Login();
        }

        private void cmdExit_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }

    }
}
