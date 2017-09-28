# Kidino's Codeigniter Base Project

This is complete rewrite of my previous KidinoCI, though with the same third-party libraries.

This is my personal base for starting a Codeigniter project. It is still a work-in-progress. You are free to use and propose changes.

Some features:

* Bootstrap 3.0
* Tank Auth views now integrated with Bootstrap 3.0
* Codeigniter 3.0
* DRY with Public_Controller & Loggedin_Controller
* MY_Model by avenirer
* GroceryCRUD, extended capabilities to support soft delete function of MY_Model (by avenirer)
* SMTP mailing with PHPMailer (ivantcholakov)
* Key-Value Application Setting library
* Basic user management based on Tank Auth user tables
* Basic ACL with permission type and groups, and assigning those groups to users

## How To Get Started

1. Deploy the base.sql in your database
2. Create your ```application/config/database.php``` config file based on ```application/config/database-sample.php```
3. Update your ```application/config/config.php``` your website details, such as the ```base_url``` and other configurations.
4. Point your browser to your base URL.
5. Login with username ```admin``` and password ```admin1234```

## Basic Info

### Access & Privileges

Basically there are two types of users

1. Super
2. Normal

You can edit a user and activate ```is_super``` to grant full access to the system to a user.

For other users that do not have the ```is_super``` privilege, they can be controlled with **Access Type**, **Groups** and by assigning **Groups** to the users.

You can also create your own **Access Type** to be used with your own codes.

Here is an example on how to implement access control. You can find this in ```application/controllers/Usersp.php``` line 102. This would mean that the user must have access type _admin_groups_ to access the page.

```
function groups() {

	if (!check_access('admin_groups')) {
		redirect('dashboard/invalid');
	}

	$this->data['page_title'] = 'User Groups';
	$this->load->library('grocery_CRUD',null,'gc');

	$this->gc->set_table('user_groups');
	$this->gc->set_subject('User Group', 'User Groups');

	$this->gc->add_action('Access', base_url('assets/grocery_crud/themes/flexigrid/css/images/table_key.png'), 'users/group_access', 'ui-icon-locked');

	$this->_gc_view();
}
```

### Keeping it DRY, Public_Controller, Loggedin_Controller

Generally the ```application/core``` folder has a few controllers

1. MY_Controller extends the CI_Controller
2. Public_Controller extends MY_Controller
3. Loggedin_Controller extends MY_Controller

#### Public_Controller

This controller is created to public facing web pages, that does not require the visitor to be logged in. The Auth controller (by Tank Auth library) uses this controller.

#### Loggedin_Controller

This controller is created to protect web pages that require login. Since all other pages in this project require a valid login session, they all use this Loggedin_Controller.

### MY_Model

KidinoCI is also bundled with MY_Model by avenirer. For DB operations that is not done via GroceryCRUD, you can use MY_Model by averiner. This MY_Model supports soft delete, and is also implemented in GroceryCRUD. It requires the TIMESTAMP columns ```deleted_at```, ```created_at``` and ```updated_at``` to support soft delete operations. You can create your own model by extending MY_Model.

You can read more information about MY_Model by averiner here:
https://github.com/avenirer/CodeIgniter-MY_Model

### GroceryCRUD

GroceryCRUD makes building a CRUD system quick and easy with Codeigniter. 

The Loggedin_Controller contains a lot of the modification to make GroceryCRUD works well with KidinoCI. However, it is not preloaded. You still have to load GroceryCRUD when you want to use them. You can do that with this code. 

```
	$this->load->library('grocery_CRUD',null,'gc');
	$this->gc->set_table('user_groups');
```

Basically, if you want to use GroceryCRUD, it is recommended that your controller extends the Loggedin_Controller.

GroceryCRUD is capabile of displaying data using Datatables and Flexgrid. But my experience is that it works best with Flexgrid.

You can read more about GroceryCRUD here:
https://www.grocerycrud.com/

### Contacts Controller Module

I created the Contacts module to demonstrate building a simple module with KidinoCI. You can see how I use GroceryCRUD, and using the Loggedin_Controller to create this module.

Each user of the system will have their own set of contacts.

# The action is in the codes

Final words, thank you for checking this out. I welcome your feedbacks.

Also, do check the codes because that is where the action is. ```application/core/Loggedin_Controller.php``` has a lot going on to integrate GroceryCRUD into KidinoCI. Apart from the ```application/controllers/Contacts.php```, ```application/controllers/Usersp.php``` also contains a lot of examples on how to use Loggedin_Controller.php.
