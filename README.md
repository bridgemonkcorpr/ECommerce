# KM: Open-Source Laravel eCommerce Framework

<img src="screenshots/01.png" alt="KM Screenshot" style="max-width:100%; border-radius:8px;">

**KM** is an open-source [Laravel eCommerce](https://laravel.com/) framework that combines the power of [Laravel](https://laravel.com/) (a [PHP](https://secure.php.net/) framework) and [Tailwind CSS](https://tailwindcss.com/). Utilizing [Vite](https://vite.dev/), it provides a modern, fast, and efficient development experience.

KM streamlines the process of launching online stores, reducing the time, cost, and effort needed to take your business online. Whether you're a small business or a large enterprise, KM is flexible, robust, and easy to set up!

---

## 🚀 Deployment

Deploy KM by following these simple steps:

```bash
# Install dependencies
composer install

# Run migrations
php artisan migrate

# Alternatively, import the provided SQL file
# located in /database/data/bridgemonkcorp.sql

# Start the server
php artisan serve
```

---

## 📋 Getting Started

### [📹 Install KM](https://www.youtube.com/watch?v=1J7U5n7h8Lo)

Follow the [Getting Started with KM](https://www.youtube.com/watch?v=1J7U5n7h8Lo) video tutorial for step-by-step guidance.



## 🛠️ Technologies Used

KM is built with the following core technologies:

- **Laravel** - A robust PHP framework for backend development.
- **Tailwind CSS** - Utility-first CSS framework for modern UI design.
- **Vite** - A modern frontend tooling system for fast build and development.
- **MySQL** - Relational database for data management.
- **PHP 8.1+** - Backend scripting language.
- **Alpine.js** - Lightweight JavaScript library for interactivity.
- **Livewire** - Full-stack framework for dynamic UI without JavaScript.
- **Nginx/Apache** - Web server support.
- **Composer** - Dependency management tool for PHP.
- **Node.js & NPM** - For building frontend assets.
- **Git** - Version control system for collaboration.

---

## 🖥️ Processor and System Requirements

To run KM smoothly, the following system requirements are recommended:

### Minimum Requirements:
- **Processor**: Dual-core CPU (2 GHz)
- **RAM**: 2 GB
- **Storage**: 10 GB free space
- **Operating System**: Ubuntu 20.04+, Windows 10+, macOS 10.14+
- **PHP Version**: 8.1 or higher
- **Database**: MySQL 5.7 or MariaDB 10.2
- **Node.js**: v16+ with npm
- **Web Server**: Apache 2.4+ or Nginx 1.18+

### Recommended Requirements:
- **Processor**: Quad-core CPU (3 GHz)
- **RAM**: 4 GB or higher
- **Storage**: 20 GB SSD
- **Operating System**: Ubuntu 22.04, macOS 12, or Windows Server 2022
- **PHP Version**: 8.2+
- **Database**: MySQL 8.0+ or MariaDB 10.5+
- **Node.js**: v18+ with npm
- **Web Server**: Nginx or Apache with SSL enabled.

---

## 💰 Technology Cost

While KM is free and open-source under the MIT License, here are the associated technology costs (optional depending on setup):

### Hosting Providers:
- **Shared Hosting**: $5–$15/month
- **VPS Hosting**: $20–$50/month
- **Cloud Hosting** (AWS/Azure/Google Cloud): $10–$100/month depending on usage.

### Domain Name:
- **Cost**: $10–$20/year

### SSL Certificate:
- **Free**: (e.g., Let’s Encrypt)
- **Premium**: $50–$200/year

### Mail Service (Optional):
- **Mailtrap, SendGrid, or Mailgun**: Free to $20/month depending on emails sent.

### Premium Plugins or Themes (Optional):
- **Cost**: $50–$500 (one-time).

### Storage Costs (Optional for product images, files):
- **Amazon S3 or DigitalOcean Spaces**: $5–$20/month.

### Example Cost Breakdown:
| Service               | Option           | Estimated Cost |
|-----------------------|------------------|----------------|
| **Hosting**           | Shared Hosting   | $10/month      |
| **Domain Name**       | .com Domain      | $12/year       |
| **SSL Certificate**   | Let’s Encrypt    | Free           |
| **Mail Service**      | Mailtrap         | Free Plan      |
| **Storage**           | Amazon S3        | $5/month       |


### Initial Setup Steps

#### 1. Store Setup

Configure your store with basic details like store name, description, email address, and phone number. Access the setup page at [http://localhost:8000/admin/setup](http://localhost:8000/admin/setup).

<img src="screenshots/Screenshot (119).png" alt="Store Setup Screenshot" style="max-width:100%; border-radius:8px;">

#### 2. Admin Setup

Create your admin account by entering a name, email, and password. Click "Next" to proceed.

<img src="screenshots/Screenshot (120).png" alt="Admin Setup Screenshot" style="max-width:100%; border-radius:8px;">

#### 3. Verify Store Details

Review and confirm the store details you have provided.

<img src="screenshots/Screenshot (121).png" alt="Verify Details Screenshot" style="max-width:100%; border-radius:8px;">

#### 4. Access Admin Panel

Login to the admin panel using your credentials to start managing your store.

<img src="screenshots/Screenshot (122).png" alt="Admin Panel Access Screenshot" style="max-width:100%; border-radius:8px;">

#### Admin Dashboard

Explore KM's comprehensive admin dashboard to manage your store effectively:

<img src="screenshots/Screenshot (123).png" alt="Admin Dashboard Screenshot" style="max-width:100%; border-radius:8px;">

---

## 🌟 Key Features

### 🛍️ Add Products

1. Navigate to the **Products** tab.

<img src="screenshots/Screenshot (125).png" alt="Add Product Screenshot" style="max-width:100%; border-radius:8px;">

2. Fill in product details, including name, price, description, inventory, and weight.

<img src="screenshots/Screenshot (126).png" alt="Add Product Screenshot" style="max-width:100%; border-radius:8px;">

3. Upload product images to the gallery.

<img src="screenshots/Screenshot (127).png" alt="Add Product Screenshot" style="max-width:100%; border-radius:8px;">

4. Save your changes.

<img src="screenshots/Screenshot (128).png" alt="Add Product Screenshot" style="max-width:100%; border-radius:8px;">

### 📋 Product Preview

Preview how your product will appear to customers:

<img src="screenshots/Screenshot (131).png" alt="Product Preview Screenshot" style="max-width:100%; border-radius:8px;">

### 🗂️ Create Collections

Organize products into collections:
1. Add a collection title and description.

<img src="screenshots/Screenshot (133).png" alt="Create Collection Screenshot" style="max-width:100%; border-radius:8px;">

2. Select products to include.

<img src="screenshots/Screenshot (134).png" alt="Create Collection Screenshot" style="max-width:100%; border-radius:8px;">

3. Upload a collection cover image.

<img src="screenshots/Screenshot (136).png" alt="Create Collection Screenshot" style="max-width:100%; border-radius:8px;">

### 🛠️ Store Customization

Configure store themes and settings to match your brand identity:

<img src="screenshots/Screenshot (135).png" alt="Store Customization Screenshot" style="max-width:100%; border-radius:8px;">

### 🚚 Shipping Rules

Define shipping rates and zones:

1. Add shipping name & select country zone.
<img src="screenshots/Screenshot (139).png" alt="Shipping Rules Screenshot" style="max-width:100%; border-radius:8px;">

2. Specify rates based on weight or price.

<img src="screenshots/Screenshot (142).png" alt="Shipping Rules Screenshot" style="max-width:100%; border-radius:8px;">

3. Add conditions and descriptions for each rate.

<img src="screenshots/Screenshot (143).png" alt="Shipping Rules Screenshot" style="max-width:100%; border-radius:8px;">

### 🌍 Tax Zones

Set up tax zones for country-specific rates:

<img src="screenshots/Screenshot (144).png" alt="Tax Zone Screenshot" style="max-width:100%; border-radius:8px;">

1. Define tax percentages.

<img src="screenshots/Screenshot (145).png" alt="Tax Zone Screenshot" style="max-width:100%; border-radius:8px;">

2. Prioritize multiple tax rules.

<img src="screenshots/Screenshot (146).png" alt="Tax Zone Screenshot" style="max-width:100%; border-radius:8px;">

### 💸 Discounts

Create and manage discounts easily:
1. Generate discount codes.
2. Choose percentage or value-based discounts.
3. Specify applicable products or collections.
4. Set start and end dates for validity.

<img src="screenshots/Screenshot (147).png" alt="Discount Setup Screenshot" style="max-width:100%; border-radius:8px;">

### 🛒 Customer Experience

Enhance the customer journey with:
1. Easy signup.
2. Seamless product addition to cart.
3. Discount code application and smooth checkout process.

<img src="screenshots/Screenshot (151).png" alt="Customer Cart Screenshot" style="max-width:100%; border-radius:8px;">

### 📦 Admin Order Management

Monitor and manage orders directly from the admin panel:

<img src="screenshots/Screenshot (156).png" alt="Order Details Screenshot" style="max-width:100%; border-radius:8px;">

---

## 🚀 Premium Features

KM's **Premium Features** take your eCommerce store to the next level with advanced tools and functionalities:

- **Dashboard**
- **Orders**
- **Products**
- **Reviews**
- **Collections**
- **Customers**
- **Discounts**
- **Shipping**
- **Taxation**
- **Blog Posts**
- **Pages**
- **General**
- **Brand**
- **Users**
- **Navigation**
- **Carousels**
- **Layout**
- **Template**
- **Payments**
- **Checkout**

For full eCommerce features mail us on  [bridgemonkcorp@gmail.com](mailto:bridgemonkcorp@gmail.com).

---

## 🚀 Accelerate Your Online Store Launch

With KM's **Starter Pack**, you get all the foundational features needed to set up your store with ease. [Explore the KM Starter Pack](https://www.youtube.com/watch?v=1J7U5n7h8Lo).

---

## 🌐 Versatile Commerce Solutions

KM is suitable for a variety of industries like fashion, textiles, and beyond. Customize it to align with your unique business requirements!

---

## 📜 License

KM is open-source and licensed under the [MIT License](https://opensource.org/license/mit), ensuring it remains free and accessible for everyone.

---

## 🛡️ Security Vulnerabilities

If you discover any security issues, please report them privately to [bridgemonkcorp@gmail.com](mailto:bridgemonkcorp@gmail.com). Your contributions to keeping KM secure are appreciated.

---

## 🤝 Contributors

KM thrives thanks to its active community of contributors. Learn more about how you can contribute on our [Open Collective](https://opencollective.com/).

---

## 💖 Sponsors

Support KM by becoming a sponsor. Your logo will appear here with a link to your website. Interested? Email us to discuss sponsorship opportunities.
