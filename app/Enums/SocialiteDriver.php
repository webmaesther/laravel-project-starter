<?php

declare(strict_types=1);

namespace App\Enums;

enum SocialiteDriver: string
{
    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';
    case LINKEDIN_OPENID = 'linkedin-openid';
    case X = 'x';
    case SLACK = 'slack';
    case GITHUB = 'github';
    case GITLAB = 'gitlab';
    case BITBUCKET = 'bitbucket';
    case TWITCH = 'twitch';
}
