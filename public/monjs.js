function suivant(nb)
{
    if (nb == 1)
        {
            document.getElementById('RegistrationFirst').style.display = 'block';
            document.getElementById('RegistrationFourth').style.display = 'none';
        }
    if (nb == 2)
    {
        document.getElementById('RegistrationFirst').style.display = 'none';
        document.getElementById('RegistrationSecond').style.display = 'block';
    }
    else if (nb == 3)
    {
        document.getElementById('RegistrationSecond').style.display = 'none';
        document.getElementById('RegistrationThird').style.display = 'block';
    }
    else if (nb == 4)
    {
        document.getElementById('RegistrationThird').style.display = 'none';
        document.getElementById('RegistrationFourth').style.display = 'block';
    }

}

function registerUser()
{
    var mail
    var password
    var role = document.getElementsByName('role').value
    var nom
    var prenom
}
