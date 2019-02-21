@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="home view-projects">
        <div class="overlay">
            <div class="contents">
                <h1 class="ui header">Welcome to Bluemarket</h1>
                <button class="ui primary button bluemarket-button">View projects</button>
            </div>
        </div>
    </div>
    <div class="padded content">
        <div class="home info">
            <div class="ui divider"></div>
                <div class="ui two column padded grid">
                    <div class="column">
                        <h1 class="bluemarket-text">What is Bluemarket?</h1>
                        <p class="bluemarket-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <div class="column image-container">
                        <img class="ui small circular image" src="https://source.unsplash.com/200x200/?office, collaboration">
                    </div>
                </div>
            </div>
        </div>
        <div class="content ui padded grid">
            <div class="home info steps">
                <h1 class="bluemarket-text">Getting started</h1>
                <ul class="progress">
                    <li class="progress-item">
                        <p class="progress-title bluemarket-text">Step 1</p>
                        <p class="progress-info bluemarket-text">Register in the platform</p>
                    </li>
                    <li class="progress-item">
                        <p class="progress-title bluemarket-text">Step 2</p>
                        <p class="progress-info bluemarket-text">Find and submit projects</p>
                    </li>
                    <li class="progress-item">
                        <p class="progress-title bluemarket-text">Step 3</p>
                        <p class="progress-info bluemarket-text">Find and collaborate with people</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="padded content contact ui grid">
            <div class="home info contact">
                <h1 class="bluemarket-text">Contact us</h1>
                <form class="ui form">
                <div class="field">
                    <label class="bluemarket-text">Name</label>
                    <input type="text" name="first-name" placeholder="First Name">
                </div>
                <div class="field">
                    <label class="bluemarket-text">Email</label>
                    <input type="text" name="last-name" placeholder="Email">
                </div>
                <div class="field">
                    <div class="field">
                    <label class="bluemarket-text">Message</label>
                    <textarea></textarea>
                    </div>
                </div>
                <button class="ui button send" type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
@endsection