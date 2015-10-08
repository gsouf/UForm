#!/usr/bin/php
<?php

include __DIR__ . "/../../vendor/autoload.php";

use UForm\Builder;
use UForm\Render\Html\Bootstrap3;
use UForm\Render\Html\Foundation5;
use UForm\Render\Html\Materialize0;
use UForm\Render\Html\StandardHtml;

$renders = [

    "standardHtml" => new StandardHtml(),
    "bootstrap3" => new Bootstrap3(),
    "foundation5" => new Foundation5(),
    "materialize0" => new Materialize0()

];

$form = Builder::init("#", "POST")
    ->columnGroup()
        ->column(3)
            ->panel("Login informations")
                ->text("login", "Login")->required()->stringLength(2, 20)
                ->password("password", "Password")->required()->stringLength(2, 20)
                ->check("remember", "Remember (checked)", true)
            ->close()
        ->close()
        ->column(3)
            ->text("money", "Money (with tooltip, helper and error)")->required()->rightAddon("&euro;")
                ->tooltip("Give me your money")->helper("Some helper")
        ->close()
        ->column(6)
            ->select("framework", "Go to framework (with tooltip)", [

                "Bootstrap" => [
                    "Bootstrap 2 (oldest)" => "bootstrap2",
                    "bootstrap3",
                ],
                "Foundation 5" => "foundation5",
                "UIKit",

                "Material" => [
                    "Materialize" => "materialize0",
                    "MUI"
                ]
            ])->tooltip("Choose a framework to view")->leftAddon("Framework")->id("goToFramework")

        ->close()
    ->close()

    ->columnGroup()
        ->column(3)
            ->fieldset("List of checkbox")
                ->group("inputType")
                    ->columnGroup()
                        ->column(6)
                            ->panel("Text fields")
                                ->check("text", "Text", "text")
                                ->check("password", "Password (checked)", "password")
                                ->check("email", "Email", "email")
                            ->close()
                        ->close()
                        ->column(6)
                            ->check("select", "Select", "Select")
                            ->check("check", "Check (checked)", "radio")
                            ->check("radio", "Radio (checked)", "check")
                        ->close()
                    ->close()
                ->close()
            ->close()
        ->close()
        ->column(3)
            ->fieldset("Your favorite dessert")
                ->columnGroup()
                    ->column(1)
                        ->fieldset("Cake and pie")
                            ->radio("favorite_dessert", "chocolate", "Chocolate Cake")
                            ->radio("favorite_dessert", "apple-pie", "Apple pie")
                            ->radio("favorite_dessert", "cheesecake", "Cheese cake")
                        ->close()
                    ->close()
                    ->column(1)
                        ->fieldset("Fruit")
                            ->radio("favorite_dessert", "strawberry", "Strawberry with cream")
                            ->radio("favorite_dessert", "banana", "Banana (default)")
                        ->close()
                    ->close()
                    ->column(1)
                        ->fieldset("Other")
                            ->radio("favorite_dessert", "ice-cream", "Ice cream")
                            ->radio("favorite_dessert", "crepes", "Crepes")
                        ->close()
                    ->close()
                ->close()
            ->close()
        ->close()
    ->close()

    ->panel("Inlined Panel (with tooltip)")->tooltip("The following elemens are inlined")
        ->inline()
            ->text("weight", "Weight", 20)->helper("This element is inlined")->rightAddon("g")
            ->text("inlined2", "Inlined 2")
            ->text("inlined3", "Inlined 3")
        ->close()
    ->close()
    ->columnGroup()
        ->column(4)
            ->tabGroup()
                ->tab("Tab with error", true)
                    ->text("tab1validInput", "Valid input")
                    ->text("tab1invalidInput", "invalid input")->validator(function(\UForm\Validation\ValidationItem $v){$v->setInvalid();})
                ->close()
                ->tab("Tab (with tooltip)")->tooltip("additional informations")
                    ->text("tab2validInput", "Valid input")
                ->close()
                ->tab("Tab with helptext")->helper("This tab contains some message that aims to help the user")
                    ->text("tab3validInput", "Valid input")
                ->close()
            ->close()
        ->close()
        ->column(3)
            ->tabGroup()
                ->tab("Empty tab", true)
                ->close()
                ->tab("Not empty")
                    ->panel("Empty panel")
                    ->close()
                ->close()
            ->close()
        ->close()
    ->close()
    ->submit()
    ->getForm();

foreach($renders as $name=>$render){
    $data = [
        "firstname" => "bart",
        "lastname" => "simpson",
        "login" => "bart",
        "password" => "somepassword",
        "framework" => $name,
        "inputType" => ["password" => true, "check" => true, "radio" => true],
        "favorite_dessert" => "banana"
    ];

    $formContext = $form->validate($data);
    $html = file_get_contents(__DIR__ . "/../html-skeleton/$name.html");
    $html = str_replace("{{content}}", $render->render($formContext), $html);
    file_put_contents(__DIR__ . "/../../build/$name.html", $html);
}
