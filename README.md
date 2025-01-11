# Plugins for Uncode Users 🎉  

Welcome! Below is a curated list of plugins designed to enhance your experience with the **Uncode WordPress Theme**.  

---

## ⚠️ Disclaimer  

> **Please Note**: I am **not an official developer of the Uncode theme**. These plugins are provided "**as is**."  
> 
> ### Important Notice  
> - **Backup Requirement**: Before using any of these plugins, it is essential to create a full backup of your site.  
> - **Usage Agreement**: If you do not agree with this disclaimer, please refrain from using these plugins on your site.  
>
> **Liability**: I am not responsible for any site issues, plugin conflicts, or malfunctions that may occur, and I do not provide support for these plugins.  

---

Here’s how you can integrate a native "add class" functionality to your theme for customizing cursor colors based on specific HTML anchors:

Steps to Add a Class Dynamically
Locate the Theme's Custom JS or CSS Integration Area
Most modern WordPress themes have a section for adding custom JavaScript and CSS. In your theme, navigate to:

Theme Options > CSS/JS > JavaScript for custom JavaScript code.
Write a JavaScript Script
Use JavaScript to detect the specific anchor tags and add a class to them dynamically.

document.addEventListener("DOMContentLoaded", function () {
    // Select all anchor links with the specific class or attribute
    const specialLinks = document.querySelectorAll('a[href*="#lien-cta1"]');

    specialLinks.forEach((link) => {
        // Add a class to the link
        link.classList.add("special-cursor-color");
    });
});
Customize Cursor Color Using CSS
Once the class is added, use CSS to define the cursor color for those links.

Add the following to the CSS section of your theme:


@media (min-width: 960px) {
    a.special-cursor-color:hover {
        cursor: pointer;
    }
    body:not(.disable-hover) a.special-cursor-color:hover #uncode-custom-cursor span:first-child {
        background-color: #ff0000 !important; /* Replace with your desired color */
    }
}
Save and Test

Save the custom JavaScript and CSS.
Test the functionality by hovering over the links with the specific anchor (#lien-cta1).
Explanation:
JavaScript: Dynamically identifies anchor tags containing the specified anchor (#lien-cta1) and assigns a class to them.
CSS: Changes the cursor color when hovering over those specific links.
