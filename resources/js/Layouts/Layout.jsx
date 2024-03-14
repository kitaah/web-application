import { useState } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import { Link, usePage } from "@inertiajs/react";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.jsx";
import Dropdown from "@/Components/Dropdown.jsx";
import { Footer } from "@codegouvfr/react-dsfr/Footer";

export default function Authenticated({ header, children }) {
    const { auth, user } = usePage().props;
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="bg-white border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex">
                            <div className="shrink-0 flex items-center">
                                <Link href="/">
                                    <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("home")}
                                    active={route().current("home")}
                                >
                                    Accueil
                                </NavLink>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("home2")}
                                    active={route().current("home2")}
                                >
                                    DSFR
                                </NavLink>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("accessibility")}
                                    active={route().current("accessibility")}
                                >
                                    Accessibilité
                                </NavLink>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("disclaimer")}
                                    active={route().current("disclaimer")}
                                >
                                    Mentions légales
                                </NavLink>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("privacypolicy")}
                                    active={route().current("privacypolicy")}
                                >
                                    Politique de confidentialité
                                </NavLink>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("resources.index")}
                                    active={route().current("resources.*")}
                                >
                                    Ressources
                                </NavLink>
                            </div>
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    href={route("competition.index")}
                                    active={route().current("competition.*")}
                                >
                                    Compétition
                                </NavLink>
                            </div>
                            {auth.user && auth.user.email_verified_at ? (
                                <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                    <NavLink
                                        href={route("game.index")}
                                        active={route().current("game.*")}
                                    >
                                        Jeux
                                    </NavLink>
                                </div>
                            ) : (
                                <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                    <NavLink
                                        href={route("login")}
                                        active={route().current("login")}
                                    >
                                        Connexion
                                    </NavLink>
                                </div>
                            )}
                        </div>

                        {auth.user && auth.user.email_verified_at ? (
                            <div className="hidden sm:flex sm:items-center sm:ms-6">
                                <div className="ms-3 relative">
                                    <Dropdown>
                                        <Dropdown.Trigger>
                                            <span className="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    {auth.user.name}

                                                    <svg
                                                        className="ms-2 -me-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </Dropdown.Trigger>

                                        <Dropdown.Content>
                                            {(user.roles.includes('Citoyen') || user.roles.includes('Super-Administrateur')) && (
                                            <Dropdown.Link
                                                href={route("profile.edit")}
                                            >
                                                Profil
                                            </Dropdown.Link>
                                            )}
                                            {(user.roles.includes('Citoyen') || user.roles.includes('Super-Administrateur')) && (
                                                <Dropdown.Link
                                                    href={route(
                                                        "resource.userIndex"
                                                    )}
                                                >
                                                    Mes ressources
                                                </Dropdown.Link>
                                            )}
                                            <Dropdown.Link
                                                href={route("logout")}
                                                method="post"
                                                as="button"
                                            >
                                                Déconnexion
                                            </Dropdown.Link>
                                        </Dropdown.Content>
                                    </Dropdown>
                                </div>
                            </div>
                        ) : (
                            <div></div>
                        )}
                        <div className="-me-2 flex items-center sm:hidden">
                            <button
                                onClick={() =>
                                    setShowingNavigationDropdown(
                                        (previousState) => !previousState
                                    )
                                }
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    className="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        className={
                                            !showingNavigationDropdown
                                                ? "inline-flex"
                                                : "hidden"
                                        }
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={
                                            showingNavigationDropdown
                                                ? "inline-flex"
                                                : "hidden"
                                        }
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    className={
                        (showingNavigationDropdown ? "block" : "hidden") +
                        " sm:hidden"
                    }
                >
                    <div className="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            href={route("dashboard")}
                            active={route().current("dashboard")}
                        >
                            Accueil
                        </ResponsiveNavLink>
                    </div>

                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="mt-3 space-y-1">
                            <ResponsiveNavLink
                                href={route("resources.index")}
                                active={route().current("ressources.*")}
                            >
                                Ressources
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            {header && (
                <header className="bg-white shadow">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}

            <main>{children}</main>

            <Footer
                accessibility="partially compliant"
                brandTop={
                    <>
                        Ministère
                        <br />
                        DU TRAVAIL
                        <br />
                        DE LA SANTé
                        <br />
                        ET DES SOLIDARITéS
                    </>
                }
                homeLinkProps={{
                    href: "/",
                    title: "Accueil - Ministère",
                }}
            ></Footer>
        </div>
    );
}
