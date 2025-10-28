import { Alert, Code, CodeHighlight, H1, H3, P, Small, Step, Stepper, Underlined } from '@docs/components/typography';
import { Layout } from '@docs/layout';
import { ArrowRightIcon, LightbulbIcon } from 'lucide-react';
import React from 'react';

export default function Installation() {
    return (
        <div className="flex flex-col gap-16 py-4">
            <div id="installation" data-section="Installation" className="flex flex-col gap-8">
                <H1>Installation</H1>
                <P>Our auth package is designed to provide an out of the box authentication solution for your Laravel and React applications.</P>
            </div>
            <div id="prerequisites" data-section="Prerequisites" className="flex flex-col gap-8">
                <H3>Prerequisites</H3>
                <P>The packages are built for Laravel, Inertia, and React applications. More importantly, they work best with our Lira ecosystem.</P>
                <P>
                    The <Underlined>starter kit</Underlined> is a perfect starting point for building applications with Lira. We recommend using the
                    starter kit for your applications since we will be regularly updating it.
                </P>
            </div>
            <div id="getting-started" data-section="Getting started" className="flex flex-col gap-8">
                <H3>Getting started</H3>
                <Stepper>
                    <Step
                        state="active"
                        title="Install auth package"
                        description={
                            <div className="flex flex-col gap-4">
                                <P>To install the auth package we can use the composer command.</P>
                                <CodeHighlight className="language-bash">comsposer require liraui/auth</CodeHighlight>
                            </div>
                        }
                        step="1"
                    />
                    <Step
                        state="active"
                        title="Publishing configs"
                        description={
                            <div className="flex flex-col gap-4">
                                <P>
                                    To publish the configuration files for the documentation package, we will utilize the <Code>Core</Code> package
                                    configuration.
                                </P>
                                <CodeHighlight className="language-bash">{`php artisan vendor:publish --tag=liraui-config`}</CodeHighlight>
                                <Alert
                                    icon={<LightbulbIcon />}
                                    description={
                                        <P>
                                            All of the configuration for our packages are located inside one config file <Code>liraui.php</Code>.
                                        </P>
                                    }
                                />
                            </div>
                        }
                        step="2"
                    />
                    <Step
                        state="active"
                        title="Registering routes"
                        description={
                            <div className="flex flex-col gap-4">
                                <P>
                                    To register the documentation routes, we need to add the following line to the <Code>bootsrap/providers.php</Code>{' '}
                                    file.
                                </P>
                                <CodeHighlight className="language-php">
                                    {`'providers' => [
    // ...
    LiraUi\\Auth\\RouteServiceProvider::class,
],`}
                                </CodeHighlight>
                                <P>
                                    This will handle all of the routes for the core package. You can view the routes by running the{' '}
                                    <Code>php artisan route:list</Code> command.
                                </P>
                            </div>
                        }
                        step="3"
                    />
                    <Step
                        state="active"
                        title="app.tsx"
                        description={
                            <div className="flex flex-col gap-4">
                                <P>
                                    Register the tsx files for the documentation package in the <Code>resources/js/app.tsx</Code> file. This will
                                    allow you to use the <Code>resolvePageComponent</Code> function to resolve the pages for the documentation
                                    package.
                                </P>
                                <CodeHighlight className="language-tsx">
                                    {`// ...

const packagePages = {
    ...import.meta.glob('/vendor/liraui/auth/src/resources/js/pages/**/*.tsx'),
    ...import.meta.glob('/vendor/@docs/pages/**/*.tsx'),
};

// ...

resolve: (name) => {
    const [namespace, namespaceFilename] = name.includes('::') ? name.split('::') : [null, name];

    if (namespace) {
        const [vendorName, vendorPackageName] = namespace.split('-');

        const packagePath = '/vendor/\${vendorName}/\${vendorPackageName}/src/resources/js/pages/\${namespaceFilename}.tsx';

        return resolvePageComponent(packagePath, packagePages);
    }

    return resolvePageComponent('./pages/\${name}.tsx', import.meta.glob('./pages/**/*.tsx'));
},`}
                                </CodeHighlight>
                            </div>
                        }
                        step="4"
                    />
                    <Step
                        state="active"
                        title="vite.config.js"
                        description={
                            <div className="flex flex-col gap-4">
                                <P>
                                    Add the following line to the <Code>vite.config.js</Code> file as an alias.
                                </P>
                                <CodeHighlight className="language-js">
                                    {`// ...
resolve: {
    alias: {
        // ...
        'liraui': resolve(__dirname, 'vendor/liraui'),
    },
}`}
                                </CodeHighlight>
                            </div>
                        }
                        step="5"
                    />
                </Stepper>
            </div>
            <div className="flex flex-col gap-8">
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-2"></div>
                    <div className="flex items-center gap-2">
                        <Small className="text-primary font-bold">Login</Small>
                        <ArrowRightIcon size={16} />
                    </div>
                </div>
            </div>
        </div>
    );
}

Installation.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
