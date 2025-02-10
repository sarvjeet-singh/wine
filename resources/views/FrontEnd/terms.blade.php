@extends('FrontEnd.layouts.mainapp')

@section('content')
    <section class="terms-and-condition-content my-5">
        <style>
            .terms-and-condition-content h1 {
                font-size: 34px;
                color: #000;
            }

            .terms-and-condition-content h2 {
                font-size: 26px;
                color: #000;
            }

            .terms-and-condition-content a {
                color: #bba253;
                text-underline-offset: 3px;
                text-decoration-thickness: 1px;
            }

            .terms-and-condition-content input[type=checkbox] {
                border-color: #bba253;
                box-shadow: unset;
            }

            .terms-and-condition-content input[type=checkbox]:checked {
                background-color: #bba253;
            }

            .terms-and-condition-content ul {
                list-style: decimal;
            }

            .terms-and-condition-content ul ul {
                list-style: upper-roman;
            }

            .terms-and-condition-content ul li:not(:last-child) {
                margin-bottom: 10px;
            }

            .terms-and-condition-content ul li::marker {
                font-weight: 600;
                color: #000000;
            }

            @media screen and (max-width: 767px) {
                .terms-and-condition-content h1 {
                    font-size: 28px;
                }

                .terms-and-condition-content h2 {
                    font-size: 20px;
                }
            }
        </style>
        <div class="container">
            <div class="inner-sec">
                <h1 class="mb-3">Terms and Conditions</h1>
                <p class="fw-bold fst-italic">Please read our Terms & Conditions carefully, as they form the basis of the
                    agreement between you and the Wine Country Weekends marketing cooperative. Wine Country Weekends is the
                    sole
                    owner of all information collected via this platform though it may be shared with vendor partners as
                    necessary. If you do not agree to these terms and conditions, you may not become a registered user and
                    should not proceed with your registration.</p>

                <div class="my-4">
                    <h2>User Agreement</h2>
                    <p>This document constitutes your agreement with Wine Country Weekends (WCW) and your ongoing use of our
                        travel service platform. You must agree to and abide by the terms and conditions contained in this
                        document to become and/or remain a registered user in good standing. The WCW Guest Rewards programs
                        and
                        associated initiatives are administered by the Wine Country Weekends marketing team (hereafter: WCW
                        Team). Participants must be 19 years of age or older and must not reside in the province of Quebec.
                        As
                        used in this Agreement, "we", "us" and "our" refers to Wine Country Weekends, its staff, agents or
                        vendor partners while “you”, “your” and “them” refers to the subject “user”.</p>
                </div>

                <div class="my-4">
                    <h2>Right to Use</h2>
                    <p>Your right to use the platform is subject to any limitations, conditions and restrictions established
                        by
                        us from time to time, in our sole discretion. We may alter, suspend or discontinue any aspect of the
                        online platform at any time, including specific functionalities, benefits, features or content. We
                        may
                        also impose limits on specific use, access or benefits, in part or in its entirety, for specific
                        users
                        and/or groups of users without notice or liability.</p>
                </div>

                <div class="my-4">
                    <h2>Age</h2>
                    <p>There are no age restrictions on use of the platform although any user under the age of 19 years may
                        be
                        limited in their ability to access content, participate in contests or complete a transaction. </p>
                </div>

                <div class="my-4">
                    <h2>Intellectual Property</h2>
                    <p>All text, graphics or other media content utilized throughout this platform from the entry point or
                        any
                        affiliated URL, page and all related code (including but not limited to HTML, Flash, other mark-up
                        languages, and all scripts) within this site are the property of Wine Country Weekends and/or its
                        partnering vendors. All material on this website, including (but not limited to) photos, images,
                        illustrations, audio and video clips, is protected by copyrights that are owned or controlled by
                        Wine
                        Country Weekends, its vendor partners and/or any organization that is promoted within the
                        environment or
                        by association. Material from this website may not be copied, reproduced, republished, downloaded,
                        posted, transmitted or distributed in any way except in those instances such actions have been
                        authorized or deemed part of the service. Modification or use of said content for any other purpose
                        may
                        be deemed as a violation of copyright and other proprietary rights.</p>
                </div>

                <div class="my-4">
                    <h2>Code of Conduct </h2>
                    <p>Registered users/vendors must agree to use our service in accordance with the following Code of
                        Conduct:
                    </p>
                    <ul>
                        <li>You agree to treat any and all personally identifying information you may obtained through use
                            of
                            the platform as private and confidential. You also agree to not divulge any such information to
                            anyone without the permission of the person who provided it to you.</li>
                        <li>You will not post or transmit in any manner any contact information including, but not limited
                            to,
                            email addresses, "instant messenger" nicknames, telephone numbers, mailing addresses, URLs, or
                            full
                            names of any other user or unsuspecting individual through your publicly posted information
                            without
                            their express consent.</li>
                        <li>You will not use the platform to engage in any form of harassment or offensive behavior,
                            including
                            but not limited to the posting of communications, pictures or recordings which contain libelous,
                            slanderous, abusive, racist or defamatory statements, pornographic, obscene, or otherwise
                            offensive
                            language or content.</li>
                        <li>You will not use the platform to infringe on the privacy rights, property rights, or any other
                            rights of any other user.</li>
                        <li>You will be enrolled in the WCW Guest Rewards program and reap the benefits that accrue as a
                            result
                            <ul class="my-2">
                                <li>Registered users will earn the equivalent of 7% cash back reward dollars on every
                                    transaction processed via the platform. Cash back is calculated on the actual amount
                                    paid
                                    not including taxes, surcharges or any discounts applied. Cash back reward dollars have
                                    a
                                    1:1 CAD equivalence and is calculated and stored for each user on their user dashboard.
                                    Reward dollars can be applied at the user’s discretion. Users cannot earn additional
                                    cash
                                    back on reward dollars applied to a transaction.</li>
                                <li>Vendors benefit from their own payment gateway that is associated with a bank of their
                                    choice. All transactions with a vendor partner are therefore direct as funds do not
                                    first
                                    accrued in a third-party account. Third-party fees can thus be avoided.</li>
                                <li>Draws for periodic prizes are also conducted on or about June 21st & December 21st each
                                    calendar year. The Grand Prize includes a getaway package with two (2) nights’
                                    accommodation
                                    and a curated excursion. Winners will be announced within a week of the draw and prizes
                                    must
                                    be claimed and booked within a [90] day period of the social media announcement.</li>
                            </ul>
                        </li>
                        <li>You will not use the platform to distribute or upload any virus, Trojan horses or do anything
                            else
                            that might cause harm to the network or to other affiliate vendor systems in any way.</li>
                        <li>You will not post messages, pictures or recordings or use the network in any way which:
                            <ul class="my-2">
                                <li>Plagiarizes or infringes upon the rights of any third party, including but not limited
                                    to
                                    any copyright or trade-mark law, privacy or other personal or proprietary rights, or;
                                </li>
                                <li>Violates any other law, is fraudulent or otherwise unlawful;</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="my-4">
                    <h2>User Classes</h2>
                    <p>There are two fundamental registered user classes; <b><i>personal</i></b> and <b><i>vendor</i></b>.
                        Both
                        categories have their own sub-sets or user statuses but the two top level categories are detailed
                        below:
                    </p>
                    <div class="ps-3">
                        <h6 class="fw-bold">Personal</h6>
                        <p>Personal accounts are representative of individual users. Registrants are also members of the
                            regional Guest Rewards program. Registered users are able to access their secure user dashboard,
                            process transactions, submit testimonials & reviews, earn cash back rewards, participate in
                            contests
                            and more.</p>
                    </div>
                    <div class="ps-3">
                        <h6 class="fw-bold">Vendor</h6>
                        <p>Vendor accounts are representative of an organization or enterprise promoted via the platform
                            and/or
                            participating in the marketing cooperative. Vendor accounts can only be initiated by system
                            administrators but potential listings can be submitted by registered users. Vendor accounts also
                            serve as content that users are able to sort through when sourcing accommodations, excursions or
                            wineries.</p>
                    </div>
                    <p>Any registered user or vendor that supplies or produces content are considered a content oriented
                        registered entity (CORE) account. CORE users and vendor accounts provide the content that helps to
                        drive
                        interactions on the platform.</p>
                </div>

                <div class="my-4">
                    <h2>Subscription Plans</h2>
                    <p>Vendor partners are expected to pay subscription fees to cover the costs associated with the
                        continued
                        development of the online platform and marketing initiatives. Subscription plans will vary by term.
                        The
                        longer the selected renewal term, the more the respective fees are discounted. Longer terms will
                        therefore encourage longer commitments and as often is the case, the longer the commitment, the more
                        substantive the results that can be expected.</p>
                    <p>Vendor account administrators are ultimately able to choose the initial and subsequent length of
                        their
                        subscription plans. All plans can be terminated with a minimum of 30 days notice prior to the
                        scheduled
                        renewal date. The plan will therefore cease to renew once the termination notice is recorded, if
                        received within the allotted period.</p>
                    <p>Any benefits that accrue as a result of the continuity of the subject plan will similarly be rendered
                        null and void (i.e. profile ranking position). Vendor partners enjoy profile rankings that are
                        superior
                        to all other vendor account status. In conjunction, vendors are typically afforded the next
                        available
                        ranking position and that position is maintained or upgraded when positions ahead are vacated due to
                        subscription cancellations. For each subscription cancelled the vendor positions that follow are
                        updated
                        accordingly. If multiple positions are vacated then the same number of positions will be gained by
                        the
                        vendors that follow. Vendors that maintain their subscriptions uninterrupted will retain their
                        positions
                        and/or qualify for upgrades as positions ahead of them become available.</p>
                    <p>Once payment has been secured the subject vendor account will be upgraded accordingly. If e-commerce
                        access or functionality has been suspended due to lack of continuous payment, any fees paid to date
                        are
                        automatically and immediately forfeited. <b>Accounts and/or surplus fees are not transferable</b>.
                    </p>
                    <p>The published price for subscription plans may vary with vendor categories and may be subject to
                        applicable taxes and service charges. Users agree to pay or have paid all fees and charges incurred
                        in
                        connection with their account (including any applicable taxes) at the rates in effect when the
                        charges
                        were incurred. All fees and charges are nonrefundable. The WCW Team may change the fees and charges
                        applicable to using the platform, or add new fees or charges, by posting new fees and changes on the
                        site from time to time. Users will also be responsible for any fees or charges incurred to access
                        the
                        platform through an internet service provider or other third party service. </p>
                </div>

                <div class="my-4">
                    <h2>Privacy and Use of Information</h2>
                    <p>By agreeing to the terms and conditions laid out within this document users are also consenting to
                        the
                        terms of our <b>Privacy Policy</b>. Users acknowledge that:</p>
                    <ul>
                        <li>The WCW Team cannot solely ensure the security or privacy of any information you provide through
                            the
                            internet, internal messaging system or email, and you release them from any and all liability in
                            connection with the use of any such information by other parties.</li>
                        <li>Users agree to the sharing of personally identifying information with any vendor they choose to
                            transact with. Vendors may require personally identifying information to process bookings,
                            deliver
                            purchased merchandise or to facilitate services being rendered.</li>
                        <li>We are not responsible for, and cannot control, the use by others of any information which you
                            provide to them and you should use caution in what personal information you provide to others
                            via
                            the platform.</li>
                        <li>We do not assume any responsibility for the content of messages sent by other users of the
                            network,
                            and you release them from any and all liability in connection with the contents of any
                            communications you may receive from other users.</li>
                        <li>We cannot guarantee, and assumes no responsibility for verifying, the accuracy of the
                            information
                            provided by platform users. Vendor contact information is provided where known. We recommend
                            that
                            users seek verification form vendors whenever possible.</li>
                        <li>You may not use the network for any unlawful purpose. The WCW Team may disallow the use of any
                            ID or
                            nickname that impersonates someone else, is protected by trade-mark or proprietary law, or is
                            vulgar
                            or otherwise offensive, as determined in their sole discretion.</li>
                    </ul>
                </div>

                <div class="my-4">
                    <h2>Monitoring of Information</h2>
                    <p>The WCW Team reserves the right to monitor and censor all advertisements, public postings and
                        messages to
                        ensure that they conform to the content guidelines which may be applicable.</p>
                </div>

                <div class="my-4">
                    <h2>Removal of Information</h2>
                    <p>While The WCW Team does not and cannot review every message or material posted or sent by users of
                        the
                        network, and are not responsible for the content of these messages or materials. We reserve the
                        right,
                        but are not obligated, to delete, move, or edit messages or materials, including without limitation
                        to
                        profiles, public postings and messages, that they, in their sole discretion, deem to violate the
                        code of
                        conduct set out above or any applicable content guidelines, or are otherwise deemed to be
                        unacceptable.
                        Users shall remain solely responsible for the content of profiles, public postings, messages and
                        other
                        materials they may post publicly via the platform or provide to other users.</p>
                </div>

                <div class="my-4">
                    <h2>Termination of Access to Service</h2>
                    <p>The WCW Team may, in their sole discretion, terminate or suspend user access to all or part of the
                        platform at any time, with or without notice, for any reason, including and without limitation to
                        breach
                        of this agreement. Without limiting the generality of the foregoing, any fraudulent, abusive, or
                        otherwise illegal activity that may otherwise affect the enjoyment of the platform or the internet
                        by
                        others may be grounds for the termination of user access to all or part of the platform, at our sole
                        discretion, and users may be referred to appropriate law enforcement agencies.</p>
                </div>

                <div class="my-4">
                    <h2>Proprietary Information</h2>
                    <p>The WCW platform contains information which is proprietary to the WCW Team, their partners and users.
                        We
                        assert full copyright protection throughout the platform. Information posted by the team, our
                        partners
                        or users of the network may be protected whether or not it is identified as proprietary to us or to
                        them. Users agree not to modify, copy or distribute any such information in any manner whatsoever
                        without having first received the express permission of the owner of such information.</p>
                </div>

                <div class="my-4">
                    <h2>No Responsibility</h2>
                    <p>Users acknowledge that the WCW Team is not responsible for the suspension of the platform, regardless
                        of
                        the cause of the interruption or suspension. Any claim against the WCW Team shall be limited to the
                        amount paid, if any, for use of the network during the previous 12 months. The WCW Team may
                        discontinue
                        or change the services provided through the platform or its availability to users at any time. Users
                        may
                        stop using the platform and its services at any time.</p>
                </div>

                <div class="my-4">
                    <h2>Security</h2>
                    <p>User accounts are private and should not be used by anyone else. Users are responsible for all usage
                        or
                        activity on the platform gained through access by their login credentials, including but not limited
                        to
                        use of their username and password by a third party.</p>
                </div>

                <div class="my-4">
                    <h2>External Links</h2>
                    <p>The platform may, from time to time, contain links to other internet sites and resources (i.e.
                        external
                        links). Users acknowledge that the WCW Team is not responsible for, and have no liability as a
                        result
                        of, the availability of External Links or their content. The WCW Team suggest that users review the
                        terms of use and privacy policy of any such external links visited, prior to their use.</p>
                </div>

                <div class="my-4">
                    <h2>Indemnity</h2>
                    <p>Users agree to indemnify the WCW Team, officers, directors, employees and agents, from any loss or
                        damages, including without limitation reasonable legal fees, which may be suffered from user
                        activities
                        or use, including without limitation to any breach of this agreement or any charges or complaints
                        made
                        by other parties against a user. Users shall cooperate as fully as reasonably required in the
                        defense of
                        any claim. We reserve the right to assume the exclusive defense and control of any matter otherwise
                        subject to indemnification by a user; provided, however, that user shall remain liable for any such
                        claim.</p>
                </div>

                <div class="my-4">
                    <h2>No Warranties</h2>
                    <p>The platform is distributed on an "as is" basis. The WCW Team does not warrant that this platform
                        will be
                        uninterrupted or error-free. There may be delays, omissions, and interruptions in the availability
                        of
                        content or any service provide through the platform. Where permitted by law, users acknowledge that
                        the
                        platform is provided without any warranties of any kind, either express or implied, including but
                        not
                        limited to the implied warranties of merchantability and fitness for a particular purpose. Users
                        acknowledge that use of the platform is at their own risk.</p>
                    <p>The WCW Team does not represent or endorse the accuracy or reliability of any vendor profile, advice,
                        opinion, statement or other information displayed, uploaded or distributed through the network by
                        Wine
                        Country Weekends, their partners or any user of the platform or any other person or entity. Users
                        acknowledge that any reliance upon any such opinion, member profile, advice, statement or
                        information
                        shall be at their own risk. Any users continued use of the platform now, or following the posting of
                        notice of any changes in this agreement, will constitute a binding acceptance by them of this
                        agreement,
                        or any subsequent modifications.</p>
                </div>

                <div class="my-4">
                    <h2>Modifications</h2>
                    <p>The WCW Team may modify this agreement from time to time. Notification of changes in this agreement
                        will
                        be posted on the website or sent via electronic mail, as may be determine in the WCW Team sole
                        discretion. If users do not agree to any modifications, they should terminate their use of the
                        network
                        immediately. Any continued use of the platform now, or following the posting of a notice of any
                        changes
                        in this agreement, will constitute a binding acceptance by the user of this agreement, or any
                        subsequent
                        modifications.</p>
                </div>

                <div class="my-4">
                    <h2>Disclosure and Other Communication</h2>
                    <p>The WCW Team reserves the right to send electronic mail to users, for the purpose of informing them
                        of
                        changes or additions to the network or of any Wine Country Weekends related products and/or
                        services.
                        The WCW Team reserves the right to disclose information about user activity on the platform and
                        demographics in forms that do not reveal any user’s personal identity.</p>

                    <p class="fw-bold">And by the use of the platform, users consent to such disclosures and communications
                        subject to the terms of the Privacy Policy.</p>
                </div>

                <div class="my-4">
                    <h2>Governing Law</h2>
                    <p>This Agreement is entered into in Ontario, Canada. Users agree that it will be governed by the laws
                        of
                        the Province of Ontario and any disputes arising out of this Agreement will be subject to the courts
                        of
                        the Province of Ontario and the federal courts applicable within the Province. If any provision in
                        this
                        Agreement is invalid or unenforceable under applicable law, the remaining provisions will continue
                        in
                        full force and effect. This Agreement will not be governed by the United Nations Convention on
                        Contracts
                        for the International Sale of Goods.</p>

                    <p>Les parties acceptent d'un commun accord que la presente entente soit redigee en anglais.</p>

                    <p>THE PARTIES SPECIFICALLY AGREE THAT THE PERFORMANCE OF THIS AGREEMENT, IN ALL ITS ASPECTS, DOES NOT
                        TAKE
                        PLACE OUTSIDE THE JURISDICTION OF THE PROVINCE OF ONTARIO, CANADA.</p>
                </div>

                <div class="my-4">
                    <h2>Assignment</h2>
                    <p>Users do not have the right to assign this agreement or any of their rights to the platform to
                        anyone.
                        Wine Country Weekends has the right to assign any or all of its rights and duties under this
                        agreement
                        or to the platform to any third party. At the election of Wine Country Weekends, if Wine Country
                        Weekends’ obligations hereunder are assumed by a third party, Wine Country Weekends shall be
                        relieved of
                        any and all liability under this Agreement.</p>

                    <p class="fw-bold theme-color">© Wine Country Weekends, 2025</p>
                </div>
            </div>
        </div>
    </section>
@endsection
